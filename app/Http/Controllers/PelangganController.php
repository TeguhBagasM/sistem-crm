<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\CalonPelanggan;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $query = Pelanggan::with('pemilik');

        // Search filter
        if (request('search')) {
            $query->where('nama', 'like', '%' . request('search') . '%')
                  ->orWhere('no_telepon', 'like', '%' . request('search') . '%');
        }

        // Status filter
        if (request('status')) {
            $query->where('status_pelanggan', request('status'));
        }

        // Owner filter
        if (request('pemilik')) {
            $query->where('pemilik_data', request('pemilik'));
        }

        $pelanggan = $query->latest()->paginate(15);

        // Statistics
        $aktifCount = Pelanggan::where('status_pelanggan', 'aktif')->count();
        $tidakAktifCount = Pelanggan::where('status_pelanggan', 'tidak_aktif')->count();
        $konversiCount = Pelanggan::whereNotNull('id_calon_pelanggan')->count();

        // User list for filter
        $userList = User::all();

        return view('pelanggan.index', compact('pelanggan', 'aktifCount', 'tidakAktifCount', 'konversiCount', 'userList'));
    }

    public function create()
    {
        $leads = CalonPelanggan::qualified()
            ->whereDoesntHave('pelanggan')
            ->get();

        return view('pelanggan.create', compact('leads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_calon_pelanggan' => 'nullable|exists:calon_pelanggan,id',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'required|string|max:20',
            'perusahaan' => 'nullable|string|max:255',
            'status_pelanggan' => 'required|in:aktif,tidak_aktif',
        ]);

        $validated['pemilik_data'] = auth()->id();

        $pelanggan = Pelanggan::create($validated);

        // Update status lead jika ada
        if ($validated['id_calon_pelanggan']) {
            CalonPelanggan::find($validated['id_calon_pelanggan'])
                ->update(['status_lead' => 'dikonversi']);
        }

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load(['pemilik', 'calonPelanggan', 'riwayatEmail', 'jadwalAktivitas']);
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'required|string|max:20',
            'perusahaan' => 'nullable|string|max:255',
            'status_pelanggan' => 'required|in:aktif,tidak_aktif',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }
}
