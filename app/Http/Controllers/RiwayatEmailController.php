<?php

namespace App\Http\Controllers;

use App\Models\RiwayatEmail;
use App\Models\Pelanggan;
use App\Mail\SendEmailToPelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
        ]);

        $validated['dikirim_oleh'] = auth()->id();

        RiwayatEmail::create($validated);

        return redirect()->route('emails.index')
            ->with('success', 'Riwayat email berhasil ditambahkan!');
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
        ]);

        $email->update($validated);

        return redirect()->route('emails.index')
            ->with('success', 'Riwayat email berhasil diperbarui!');
    }

    public function destroy(RiwayatEmail $email)
    {
        $email->delete();

        return redirect()->route('emails.index')
            ->with('success', 'Riwayat email berhasil dihapus!');
    }

    /**
     * Send email to pelanggan
     */
    public function send(Request $request, RiwayatEmail $email)
    {
        try {
            // Validasi email pelanggan
            if (!$email->pelanggan->email) {
                return back()->with('error', 'Pelanggan tidak memiliki email!');
            }

            // Send email
            Mail::to($email->pelanggan->email)
                ->send(new SendEmailToPelanggan($email));

            // Update status email
            $email->update([
                'status_kirim' => 'sent',
                'waktu_terkirim' => now(),
            ]);

            Log::info("Email sent successfully", [
                'email_id' => $email->id,
                'to' => $email->pelanggan->email,
                'subject' => $email->subjek,
                'sent_by' => auth()->user()->name
            ]);

            return back()->with('success', '✓ Email berhasil dikirim ke ' . $email->pelanggan->email . '!');
        } catch (\Exception $e) {
            // Update status email to failed
            $email->update([
                'status_kirim' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            Log::error("Error sending email", [
                'email_id' => $email->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', '✗ Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
