<?php

namespace App\Http\Controllers;

use App\Models\JadwalAktivitas;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class JadwalAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalAktivitas::with(['pelanggan', 'pembuat']);

        // Filter by jenis_aktivitas
        if ($request->filled('jenis_aktivitas')) {
            $query->where('jenis_aktivitas', 'like', '%' . $request->jenis_aktivitas . '%');
        }

        // Filter by status_aktivitas
        if ($request->filled('status_aktivitas')) {
            $query->where('status_aktivitas', $request->status_aktivitas);
        }

        // Filter by tanggal (single date)
        $selectedDate = null;
        if ($request->filled('tanggal')) {
            $selectedDate = $request->tanggal;
            $query->whereDate('tanggal_jadwal', $selectedDate);
        } else {
            // Filter by date range
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal_jadwal', '>=', $request->tanggal_dari);
            }

            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal_jadwal', '<=', $request->tanggal_sampai);
            }
        }

        $aktivitas = $query->latest()->paginate(15);

        // Statistics
        $totalAktivitas = JadwalAktivitas::count();
        $aktivitasDirencanakan = JadwalAktivitas::where('status_aktivitas', 'direncanakan')->count();
        $aktivitasSelesai = JadwalAktivitas::where('status_aktivitas', 'selesai')->count();
        $aktivitasHariIni = JadwalAktivitas::whereDate('tanggal_jadwal', now()->toDateString())->count();

        // Get calendar data (all activities for month)
        $currentMonth = $request->filled('bulan') ? \Carbon\Carbon::createFromFormat('Y-m', $request->bulan) : now();
        $calendarData = JadwalAktivitas::whereBetween('tanggal_jadwal', [
            $currentMonth->clone()->startOfMonth(),
            $currentMonth->clone()->endOfMonth()
        ])->get()->groupBy(fn($item) => $item->tanggal_jadwal->format('Y-m-d'));

        return view('aktivitas.index', compact(
            'aktivitas',
            'totalAktivitas',
            'aktivitasDirencanakan',
            'aktivitasSelesai',
            'aktivitasHariIni',
            'calendarData',
            'currentMonth',
            'selectedDate'
        ));
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
            'jenis_aktivitas' => 'required|string|max:100',
            'tanggal_jadwal' => 'required|date',
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
        ]);

        $validated['dibuat_oleh'] = auth()->id();
        $validated['status_aktivitas'] = 'direncanakan';

        JadwalAktivitas::create($validated);

        return redirect()->route('aktivitas.index')
            ->with('success', 'Jadwal aktivitas berhasil ditambahkan!');
    }

    public function show(JadwalAktivitas $aktivita)
    {
        $aktivitas = $aktivita; // Fix naming for consistency
        $aktivitas->load(['pelanggan', 'pembuat']);
        return view('aktivitas.show', compact('aktivitas'));
    }

    public function edit(JadwalAktivitas $aktivita)
    {
        $aktivitas = $aktivita; // Fix naming for consistency
        $pelanggan = Pelanggan::aktif()->orderBy('nama')->get();
        return view('aktivitas.edit', compact('aktivitas', 'pelanggan'));
    }

    public function update(Request $request, JadwalAktivitas $aktivita)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_aktivitas' => 'required|string|max:100',
            'tanggal_jadwal' => 'required|date',
            'status_aktivitas' => 'required|in:direncanakan,selesai',
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
        ]);

        $aktivita->update($validated);

        return redirect()->route('aktivitas.index')
            ->with('success', 'Jadwal aktivitas berhasil diperbarui!');
    }

    public function destroy(JadwalAktivitas $aktivita)
    {
        $aktivita->delete();

        return redirect()->route('aktivitas.index')
            ->with('success', 'Jadwal aktivitas berhasil dihapus!');
    }

    public function updateStatus(Request $request, JadwalAktivitas $aktivita)
    {
        $validated = $request->validate([
            'status_aktivitas' => 'required|in:direncanakan,selesai',
        ]);

        $aktivita->update($validated);

        return back()->with('success', 'Status aktivitas berhasil diperbarui!');
    }
}
