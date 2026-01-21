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
        $data = [];

        // Admin Dashboard - Key metrics only
        if ($user->isAdmin()) {
            $data = [
                'role' => 'admin',
                'total_leads' => CalonPelanggan::count(),
                'total_pelanggan' => Pelanggan::count(),
                'total_email' => RiwayatEmail::count(),
                'total_aktivitas' => JadwalAktivitas::count(),
                'total_user' => \App\Models\User::count(),

                // Summary for admin
                'leads_summary' => [
                    'baru' => CalonPelanggan::baru()->count(),
                    'qualified' => CalonPelanggan::qualified()->count(),
                    'dikonversi' => CalonPelanggan::dikonversi()->count(),
                ],
                'pelanggan_summary' => [
                    'aktif' => Pelanggan::aktif()->count(),
                    'tidak_aktif' => Pelanggan::tidakAktif()->count(),
                ],

                // Charts for admin
                'leads_chart' => [
                    'labels' => ['Baru', 'Dihubungi', 'Qualified', 'Dikonversi', 'Gagal'],
                    'data' => [
                        CalonPelanggan::baru()->count(),
                        CalonPelanggan::dihubungi()->count(),
                        CalonPelanggan::qualified()->count(),
                        CalonPelanggan::dikonversi()->count(),
                        CalonPelanggan::gagal()->count(),
                    ],
                ],

                'pelanggan_chart' => [
                    'labels' => ['Aktif', 'Tidak Aktif'],
                    'data' => [
                        Pelanggan::aktif()->count(),
                        Pelanggan::tidakAktif()->count(),
                    ],
                ],

                'email_chart' => [
                    'labels' => ['Bulan Ini', 'Minggu Ini', 'Total'],
                    'data' => [
                        RiwayatEmail::whereMonth('waktu_kirim', now()->month)->count(),
                        RiwayatEmail::whereDate('waktu_kirim', '>=', now()->subWeek())->count(),
                        RiwayatEmail::count(),
                    ],
                ],
            ];
        }
        // Marketing 1 - Lead Management
        elseif ($user->isMarketing1()) {
            $data = [
                'role' => 'marketing1',
                'total_leads' => CalonPelanggan::count(),
                'leads_baru' => CalonPelanggan::baru()->count(),
                'leads_dihubungi' => CalonPelanggan::dihubungi()->count(),
                'leads_qualified' => CalonPelanggan::qualified()->count(),
                'leads_dikonversi' => CalonPelanggan::dikonversi()->count(),
                'leads_gagal' => CalonPelanggan::gagal()->count(),

                'recent_leads' => CalonPelanggan::with('pembuatData')
                    ->latest()
                    ->take(5)
                    ->get(),

                'leads_chart' => [
                    'labels' => ['Baru', 'Dihubungi', 'Qualified', 'Dikonversi', 'Gagal'],
                    'data' => [
                        CalonPelanggan::baru()->count(),
                        CalonPelanggan::dihubungi()->count(),
                        CalonPelanggan::qualified()->count(),
                        CalonPelanggan::dikonversi()->count(),
                        CalonPelanggan::gagal()->count(),
                    ],
                ],
            ];
        }
        // Marketing 2 - Contact Management
        elseif ($user->isMarketing2()) {
            $data = [
                'role' => 'marketing2',
                'total_pelanggan' => Pelanggan::count(),
                'pelanggan_aktif' => Pelanggan::aktif()->count(),
                'pelanggan_tidak_aktif' => Pelanggan::tidakAktif()->count(),

                'recent_pelanggan' => Pelanggan::with('pemilik')
                    ->latest()
                    ->take(5)
                    ->get(),

                'pelanggan_chart' => [
                    'labels' => ['Aktif', 'Tidak Aktif'],
                    'data' => [
                        Pelanggan::aktif()->count(),
                        Pelanggan::tidakAktif()->count(),
                    ],
                ],
            ];
        }
        // Marketing 3 - Email Management
        elseif ($user->isMarketing3()) {
            $data = [
                'role' => 'marketing3',
                'total_email' => RiwayatEmail::count(),
                'email_bulan_ini' => RiwayatEmail::whereMonth('waktu_kirim', now()->month)->count(),
                'email_minggu_ini' => RiwayatEmail::whereDate('waktu_kirim', '>=', now()->subWeek())->count(),

                'recent_emails' => RiwayatEmail::with(['pelanggan', 'pengirim'])
                    ->latest('waktu_kirim')
                    ->take(5)
                    ->get(),

                'email_chart' => [
                    'labels' => ['Bulan Ini', 'Minggu Ini', 'Total'],
                    'data' => [
                        RiwayatEmail::whereMonth('waktu_kirim', now()->month)->count(),
                        RiwayatEmail::whereDate('waktu_kirim', '>=', now()->subWeek())->count(),
                        RiwayatEmail::count(),
                    ],
                ],
            ];
        }
        // Marketing 4 - Activities Management
        elseif ($user->isMarketing4()) {
            $data = [
                'role' => 'marketing4',
                'total_aktivitas' => JadwalAktivitas::count(),
                'aktivitas_direncanakan' => JadwalAktivitas::direncanakan()->count(),
                'aktivitas_selesai' => JadwalAktivitas::selesai()->count(),

                'upcoming_activities' => JadwalAktivitas::with(['pelanggan', 'pembuat'])
                    ->direncanakan()
                    ->orderBy('tanggal_jadwal')
                    ->take(5)
                    ->get(),

                'aktivitas_chart' => [
                    'labels' => ['Direncanakan', 'Selesai'],
                    'data' => [
                        JadwalAktivitas::direncanakan()->count(),
                        JadwalAktivitas::selesai()->count(),
                    ],
                ],
            ];
        }

        return view('dashboard', compact('data', 'user'));
    }
}
