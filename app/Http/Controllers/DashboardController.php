<?php

namespace App\Http\Controllers;

use App\Models\CalonPelanggan;
use App\Models\Pelanggan;
use App\Models\RiwayatEmail;
use App\Models\JadwalAktivitas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $data = [
            'total_leads' => CalonPelanggan::count(),
            'total_pelanggan' => Pelanggan::count(),
            'total_email' => RiwayatEmail::count(),
            'total_aktivitas' => JadwalAktivitas::count(),
        ];

        // Data spesifik per role
        if ($user->isMarketing1() || $user->isAdmin()) {
            $data['leads_baru'] = CalonPelanggan::baru()->count();
            $data['leads_qualified'] = CalonPelanggan::qualified()->count();
            $data['recent_leads'] = CalonPelanggan::with('pembuatData')
                ->latest()
                ->take(5)
                ->get();
        }

        if ($user->isMarketing2() || $user->isAdmin()) {
            $data['pelanggan_aktif'] = Pelanggan::aktif()->count();
            $data['recent_pelanggan'] = Pelanggan::with('pemilik')
                ->latest()
                ->take(5)
                ->get();
        }

        if ($user->isMarketing3() || $user->isAdmin()) {
            $data['email_bulan_ini'] = RiwayatEmail::whereMonth('waktu_kirim', now()->month)
                ->count();
            $data['recent_emails'] = RiwayatEmail::with(['pelanggan', 'pengirim'])
                ->latest('waktu_kirim')
                ->take(5)
                ->get();
        }

        if ($user->isMarketing4() || $user->isAdmin()) {
            $data['aktivitas_pending'] = JadwalAktivitas::direncanakan()->count();
            $data['upcoming_activities'] = JadwalAktivitas::with(['pelanggan', 'pembuat'])
                ->direncanakan()
                ->orderBy('tanggal_jadwal')
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('data', 'user'));
    }
}
