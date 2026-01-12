<?php

namespace App\Http\Controllers;

use App\Models\CalonPelanggan;
use Illuminate\Http\Request;

class CalonPelangganController extends Controller
{
    public function index()
    {
        $leads = CalonPelanggan::with('pembuatData')
            ->latest()
            ->paginate(15);

        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'required|string|max:20',
            'sumber' => 'required|in:IG,Website,WA',
            'catatan' => 'nullable|string',
        ]);

        $validated['dibuat_oleh'] = auth()->id();
        $validated['status_lead'] = 'baru';

        CalonPelanggan::create($validated);

        return redirect()->route('leads.index')
            ->with('success', 'Calon pelanggan berhasil ditambahkan!');
    }

    public function show(CalonPelanggan $lead)
    {
        $lead->load('pembuatData', 'pelanggan');
        return view('leads.show', compact('lead'));
    }

    public function edit(CalonPelanggan $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, CalonPelanggan $lead)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'required|string|max:20',
            'sumber' => 'required|in:IG,Website,WA',
            'status_lead' => 'required|in:baru,dihubungi,qualified,dikonversi,gagal',
            'catatan' => 'nullable|string',
        ]);

        $lead->update($validated);

        return redirect()->route('leads.index')
            ->with('success', 'Data calon pelanggan berhasil diperbarui!');
    }

    public function destroy(CalonPelanggan $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Calon pelanggan berhasil dihapus!');
    }

    public function updateStatus(Request $request, CalonPelanggan $lead)
    {
        $validated = $request->validate([
            'status_lead' => 'required|in:baru,dihubungi,qualified,dikonversi,gagal',
        ]);

        $lead->update($validated);

        return back()->with('success', 'Status lead berhasil diperbarui!');
    }
}
