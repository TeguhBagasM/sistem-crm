<?php

namespace App\Http\Controllers;

use App\Models\JadwalAktivitas;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class JadwalAktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = JadwalAktivitas::with(['pelanggan', 'pembuat'])
            ->latest()
            ->paginate(15);

        return view('aktivitas.index', compact('aktivitas'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::aktif()->orderBy('nama')->get();
        return view('aktivitas.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_aktivitas' => 'required|in:email,followup,konten',
            'tanggal_jadwal' => 'required|date',
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
        ]);

        $validated['dibuat_oleh'] = auth()->id();
        $validated['status_aktivitas'] = 'direncanakan';

        JadwalAktivitas::create($validated);

        return redirect()->route('aktivitas.index')
            ->with('success', 'Jadwal aktivitas berhasil ditambahkan!');
    }

    public function show(JadwalAktivitas $aktivitas)
    {
        $aktivitas->load(['pelanggan', 'pembuat']);
        return view('aktivitas.show', compact('aktivitas'));
    }

    public function edit(JadwalAktivitas $aktivitas)
    {
        $pelanggan = Pelanggan::aktif()->orderBy('nama')->get();
        return view('aktivitas.edit', compact('aktivitas', 'pelanggan'));
    }

    public function update(Request $request, JadwalAktivitas $aktivitas)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_aktivitas' => 'required|in:email,followup,konten',
            'tanggal_jadwal' => 'required|date',
            'status_aktivitas' => 'required|in:direncanakan,selesai',
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
        ]);

        $aktivitas->update($validated);

        return redirect()->route('aktivitas.index')
            ->with('success', 'Jadwal aktivitas berhasil diperbarui!');
    }

    public function destroy(JadwalAktivitas $aktivitas)
    {
        $aktivitas->delete();

        return redirect()->route('aktivitas.index')
            ->with('success', 'Jadwal aktivitas berhasil dihapus!');
    }

    public function updateStatus(Request $request, JadwalAktivitas $aktivitas)
    {
        $validated = $request->validate([
            'status_aktivitas' => 'required|in:direncanakan,selesai',
        ]);

        $aktivitas->update($validated);

        return back()->with('success', 'Status aktivitas berhasil diperbarui!');
    }
}
