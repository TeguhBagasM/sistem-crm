<?php

namespace App\Http\Controllers;

use App\Models\RiwayatEmail;
use App\Models\Pelanggan;
use App\Models\CalonPelanggan;
use Illuminate\Http\Request;

class RiwayatEmailController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatEmail::with(['pelanggan', 'calonPelanggan', 'pengirim']);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subjek', 'like', "%{$search}%")
                  ->orWhere('isi_pesan', 'like', "%{$search}%");
            });
        }

        // Filter by pelanggan
        if ($request->filled('pelanggan_id')) {
            $query->where('id_pelanggan', $request->pelanggan_id);
        }

        // Filter by tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('waktu_kirim', $request->tanggal);
        }

        $emails = $query->latest('waktu_kirim')->paginate(15);

        // Statistics
        $emailBulanIni = RiwayatEmail::whereMonth('waktu_kirim', now()->month)
            ->whereYear('waktu_kirim', now()->year)
            ->count();

        $emailMingguIni = RiwayatEmail::whereBetween('waktu_kirim', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        $emailHariIni = RiwayatEmail::whereDate('waktu_kirim', now()->toDateString())
            ->count();

        $pelangganList = Pelanggan::aktif()->orderBy('nama')->get();

        return view('emails.index', compact(
            'emails',
            'emailBulanIni',
            'emailMingguIni',
            'emailHariIni',
            'pelangganList'
        ));
    }

    public function create()
    {
        $pelanggan = Pelanggan::aktif()->latest()->get();
        $leads = CalonPelanggan::where('status_lead', '!=', 'dikonversi')->latest()->get();

        return view('emails.create', compact('pelanggan', 'leads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
            'id_calon_pelanggan' => 'nullable|exists:calon_pelanggan,id',
            'subjek' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'waktu_kirim' => 'required|date',
            'action' => 'required|in:save_only,send_email',
        ]);

        // Validate at least one recipient is selected
        if (empty($validated['id_pelanggan']) && empty($validated['id_calon_pelanggan'])) {
            return back()->with('error', 'Pilih pelanggan atau leads!')
                        ->withInput();
        }

        $validated['dikirim_oleh'] = auth()->id();
        $validated['status_kirim'] = 'draft';

        // Get the recipient
        $email = null;
        $nama = null;

        if ($validated['id_pelanggan']) {
            $recipient = Pelanggan::findOrFail($validated['id_pelanggan']);
            $email = $recipient->email;
            $nama = $recipient->nama;
        } else {
            $recipient = CalonPelanggan::findOrFail($validated['id_calon_pelanggan']);
            $email = $recipient->email;
            $nama = $recipient->nama;
        }

        // If action is send_email, send it
        if ($validated['action'] === 'send_email') {
            // Check if recipient has email
            if (!$email) {
                return back()->with('error', 'Penerima tidak memiliki alamat email!')
                            ->withInput();
            }

            try {
                // Send email
                \Illuminate\Support\Facades\Mail::raw($validated['isi_pesan'], function ($message) use ($email, $nama, $validated) {
                    $message->to($email)
                            ->subject($validated['subjek']);
                });

                $validated['status_kirim'] = 'sent';
                $validated['waktu_terkirim'] = now();
            } catch (\Exception $e) {
                $validated['status_kirim'] = 'failed';
                $validated['error_message'] = $e->getMessage();
                return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage())
                            ->withInput();
            }
        }

        // Remove action field before saving to database
        unset($validated['action']);

        RiwayatEmail::create($validated);

        return redirect()->route('emails.index')
            ->with('success', $validated['status_kirim'] === 'sent' ? 'Email berhasil dikirim dan dicatat!' : 'Riwayat email berhasil ditambahkan!');
    }

    public function show(RiwayatEmail $email)
    {
        $email->load(['pelanggan', 'pengirim']);
        return view('emails.show', compact('email'));
    }

    public function edit(RiwayatEmail $email)
    {
        $pelanggan = Pelanggan::aktif()->latest()->get();
        $leads = CalonPelanggan::where('status_lead', '!=', 'dikonversi')->latest()->get();

        return view('emails.edit', compact('email', 'pelanggan', 'leads'));
    }

    public function update(Request $request, RiwayatEmail $email)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
            'id_calon_pelanggan' => 'nullable|exists:calon_pelanggan,id',
            'subjek' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'waktu_kirim' => 'required|date',
            'action' => 'required|in:save_only,send_email',
        ]);

        // Validate at least one recipient is selected
        if (empty($validated['id_pelanggan']) && empty($validated['id_calon_pelanggan'])) {
            return back()->with('error', 'Pilih pelanggan atau leads!')
                        ->withInput();
        }

        // Remove action field from validated (don't save to DB)
        $action = $validated['action'];
        unset($validated['action']);

        // Get the recipient
        $recipientEmail = null;

        if ($validated['id_pelanggan']) {
            $recipient = Pelanggan::findOrFail($validated['id_pelanggan']);
            $recipientEmail = $recipient->email;
        } elseif ($validated['id_calon_pelanggan']) {
            $recipient = CalonPelanggan::findOrFail($validated['id_calon_pelanggan']);
            $recipientEmail = $recipient->email;
        }

        // If action is send_email, send it
        if ($action === 'send_email') {
            // Check if recipient has email
            if (!$recipientEmail) {
                return back()->with('error', 'Penerima tidak memiliki alamat email!')
                            ->withInput();
            }

            try {
                // Send email
                \Illuminate\Support\Facades\Mail::raw($validated['isi_pesan'], function ($message) use ($recipientEmail, $validated) {
                    $message->to($recipientEmail)
                            ->subject($validated['subjek']);
                });

                $validated['status_kirim'] = 'sent';
                $validated['waktu_terkirim'] = now();
            } catch (\Exception $e) {
                $validated['status_kirim'] = 'failed';
                $validated['error_message'] = $e->getMessage();
                return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage())
                            ->withInput();
            }
        }

        $email->update($validated);

        return redirect()->route('emails.index', $email)
            ->with('success', $action === 'send_email' ? 'Email berhasil dikirim dan data diperbarui!' : 'Riwayat email berhasil diperbarui!');
    }

    public function destroy(RiwayatEmail $email)
    {
        $email->delete();

        return redirect()->route('emails.index')
            ->with('success', 'Riwayat email berhasil dihapus!');
    }
}
