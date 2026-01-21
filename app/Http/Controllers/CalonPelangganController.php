<?php

namespace App\Http\Controllers;

use App\Models\CalonPelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalonPelangganController extends Controller
{
    public function index()
    {
        $query = CalonPelanggan::with('pembuatData');

        // Search filter
        if (request('search')) {
            $query->where('nama', 'like', '%' . request('search') . '%')
                  ->orWhere('no_telepon', 'like', '%' . request('search') . '%');
        }

        // Status filter
        if (request('status')) {
            $query->where('status_lead', request('status'));
        }

        // Source filter
        if (request('sumber')) {
            $query->where('sumber', request('sumber'));
        }

        $leads = $query->latest()->paginate(15);

        // Statistics
        $qualifiedCount = CalonPelanggan::where('status_lead', 'qualified')->count();
        $dihubungiCount = CalonPelanggan::where('status_lead', 'dihubungi')->count();
        $gagalCount = CalonPelanggan::where('status_lead', 'gagal')->count();

        return view('leads.index', compact('leads', 'qualifiedCount', 'dihubungiCount', 'gagalCount'));
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
            'sumber' => 'required|string|max:100',
            'alamat' => 'nullable|string',
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
            'sumber' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'status_lead' => 'required|in:baru,dihubungi,qualified,gagal',
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
        try {
            // Cek apakah lead sudah dikonversi ke pelanggan
            if ($lead->pelanggan) {
                return response()->json([
                    'message' => '❌ Tidak bisa mengubah status! Lead ini sudah dikonversi ke Contact Management (Pelanggan). Silakan ubah status di halaman Contact Management jika diperlukan.',
                    'status' => 'error',
                    'converted' => true
                ], 403);
            }

            $validated = $request->validate([
                'status_lead' => 'required|in:baru,dihubungi,qualified,gagal',
            ]);

            $lead->update($validated);

            // Return JSON response untuk AJAX request
            if ($request->wantsJson() || $request->isXmlHttpRequest()) {
                $baruCount = CalonPelanggan::where('status_lead', 'baru')->count();
                $dihubungiCount = CalonPelanggan::where('status_lead', 'dihubungi')->count();
                $qualifiedCount = CalonPelanggan::where('status_lead', 'qualified')->count();
                $gagalCount = CalonPelanggan::where('status_lead', 'gagal')->count();

                return response()->json([
                    'message' => 'Status lead berhasil diperbarui!',
                    'status' => 'success',
                    'data' => [
                        'id' => $lead->id,
                        'status_lead' => $lead->status_lead
                    ],
                    'stats' => [
                        'baru' => $baruCount,
                        'dihubungi' => $dihubungiCount,
                        'qualified' => $qualifiedCount,
                        'gagal' => $gagalCount
                    ]
                ], 200);
            }

            // Fallback untuk regular request
            return back()->with('success', 'Status lead berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->isXmlHttpRequest()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error updating lead status: ' . $e->getMessage());

            if ($request->wantsJson() || $request->isXmlHttpRequest()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'status' => 'error'
                ], 500);
            }
            throw $e;
        }
    }
}
