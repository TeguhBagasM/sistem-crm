<?php

namespace App\Http\Controllers;

use App\Models\RiwayatEmail;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class RiwayatEmailController extends Controller
{
    public function index()
    {
        $emails = RiwayatEmail::with(['pelanggan', 'pengirim'])
            ->latest('waktu_kirim')
            ->paginate(15);

        return view('emails.index', compact('emails'));
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
}
