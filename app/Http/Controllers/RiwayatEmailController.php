<?php

namespace App\Http\Controllers;

use App\Models\RiwayatEmail;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class RiwayatEmailController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatEmail::with(['pelanggan', 'pengirim']);

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
        $pelanggan = Pelanggan::aktif()->orderBy('nama')->get();
        return view('emails.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'subjek' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'waktu_kirim' => 'required|date',
            'action' => 'required|in:save_only,send_email',
        ]);

        $validated['dikirim_oleh'] = auth()->id();
        $validated['status_kirim'] = 'draft';

        // If action is send_email, send it
        if ($validated['action'] === 'send_email') {
            $pelanggan = Pelanggan::findOrFail($validated['id_pelanggan']);

            // Check if pelanggan has email
            if (!$pelanggan->email) {
                return back()->with('error', 'Pelanggan tidak memiliki alamat email!')
                            ->withInput();
            }

            try {
                // Send email
                \Illuminate\Support\Facades\Mail::raw($validated['isi_pesan'], function ($message) use ($pelanggan, $validated) {
                    $message->to($pelanggan->email)
                            ->subject($validated['subjek']);
                });

                $validated['status_kirim'] = 'sent';
                $validated['waktu_terkirim'] = now();
                $message = 'Email berhasil dikirim!';
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
        $pelanggan = Pelanggan::aktif()->orderBy('nama')->get();
        return view('emails.edit', compact('email', 'pelanggan'));
    }

    public function update(Request $request, RiwayatEmail $email)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id',
            'subjek' => 'required|string|max:255',
            'isi_pesan' => 'required|string',
            'waktu_kirim' => 'required|date',
            'action' => 'required|in:save_only,send_email',
        ]);

        // Remove action field from validated (don't save to DB)
        $action = $validated['action'];
        unset($validated['action']);

        // If action is send_email, send it
        if ($action === 'send_email') {
            $pelanggan = Pelanggan::findOrFail($validated['id_pelanggan']);

            // Check if pelanggan has email
            if (!$pelanggan->email) {
                return back()->with('error', 'Pelanggan tidak memiliki alamat email!')
                            ->withInput();
            }

            try {
                // Send email
                \Illuminate\Support\Facades\Mail::raw($validated['isi_pesan'], function ($message) use ($pelanggan, $validated) {
                    $message->to($pelanggan->email)
                            ->subject($validated['subjek']);
                });

                $validated['status_kirim'] = 'sent';
                $validated['waktu_terkirim'] = now();
                $message = 'Email berhasil dikirim dan data diperbarui!';
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
