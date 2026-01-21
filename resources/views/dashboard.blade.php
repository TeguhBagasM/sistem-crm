@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h2>Dashboard</h2>
    <p class="text-muted">Selamat datang, {{ $user->name }}!</p>
</div>

<!-- ADMIN DASHBOARD -->
@if($data['role'] === 'admin')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total User</h6>
                        <h2 class="mb-0">{{ $data['total_user'] }}</h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Leads</h6>
                        <h2 class="mb-0">{{ $data['total_leads'] }}</h2>
                    </div>
                    <i class="bi bi-person-plus" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Pelanggan</h6>
                        <h2 class="mb-0">{{ $data['total_pelanggan'] }}</h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Email</h6>
                        <h2 class="mb-0">{{ $data['total_email'] }}</h2>
                    </div>
                    <i class="bi bi-envelope" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Lead Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="leadsChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Status Aktivitas</h5>
            </div>
            <div class="card-body">
                <canvas id="aktivitasChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Email Stats</h5>
            </div>
            <div class="card-body">
                <canvas id="emailChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

@endif

<!-- MARKETING 1 - LEAD MANAGEMENT DASHBOARD -->
@if($data['role'] === 'marketing1')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Leads</h6>
                        <h2 class="mb-0">{{ $data['total_leads'] }}</h2>
                    </div>
                    <i class="bi bi-person-plus" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Baru</h6>
                        <h2 class="mb-0">{{ $data['leads_baru'] }}</h2>
                    </div>
                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Qualified</h6>
                        <h2 class="mb-0">{{ $data['leads_qualified'] }}</h2>
                    </div>
                    <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Dikonversi</h6>
                        <h2 class="mb-0">{{ $data['leads_dikonversi'] }}</h2>
                    </div>
                    <i class="bi bi-arrow-repeat" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Distribusi Lead</h5>
            </div>
            <div class="card-body">
                <canvas id="leadsChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-list"></i> Lead Terbaru (Top 5)</h5>
            </div>
            <div class="card-body">
                @if($data['recent_leads']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Sumber</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_leads'] as $lead)
                            <tr>
                                <td><strong>{{ Str::limit($lead->nama, 15) }}</strong></td>
                                <td><span class="badge bg-secondary">{{ Str::limit($lead->sumber, 10) }}</span></td>
                                <td><span class="badge {{ $lead->getStatusBadgeClass() }}">{{ ucfirst(str_replace('_', ' ', $lead->status_lead)) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0">Belum ada data lead.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endif

<!-- MARKETING 2 - CONTACT MANAGEMENT DASHBOARD -->
@if($data['role'] === 'marketing2')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Pelanggan</h6>
                        <h2 class="mb-0">{{ $data['total_pelanggan'] }}</h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Aktif</h6>
                        <h2 class="mb-0">{{ $data['pelanggan_aktif'] }}</h2>
                    </div>
                    <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Tidak Aktif</h6>
                        <h2 class="mb-0">{{ $data['pelanggan_tidak_aktif'] }}</h2>
                    </div>
                    <i class="bi bi-x-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Ratio Aktif</h6>
                        <h2 class="mb-0">{{ $data['total_pelanggan'] > 0 ? round(($data['pelanggan_aktif'] / $data['total_pelanggan']) * 100) : 0 }}%</h2>
                    </div>
                    <i class="bi bi-percent" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Status Pelanggan</h5>
            </div>
            <div class="card-body">
                <canvas id="pelangganChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-list"></i> Pelanggan Terbaru (Top 5)</h5>
            </div>
            <div class="card-body">
                @if($data['recent_pelanggan']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Perusahaan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_pelanggan'] as $pelanggan)
                            <tr>
                                <td><strong>{{ Str::limit($pelanggan->nama, 15) }}</strong></td>
                                <td>{{ Str::limit($pelanggan->perusahaan ?? '-', 15) }}</td>
                                <td><span class="badge {{ $pelanggan->getStatusBadgeClass() }}">{{ ucfirst($pelanggan->status_pelanggan) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0">Belum ada data pelanggan.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endif

<!-- MARKETING 3 - EMAIL MANAGEMENT DASHBOARD -->
@if($data['role'] === 'marketing3')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Email</h6>
                        <h2 class="mb-0">{{ $data['total_email'] }}</h2>
                    </div>
                    <i class="bi bi-envelope" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #17a2b8 0%, #1c8fa8 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Bulan Ini</h6>
                        <h2 class="mb-0">{{ $data['email_bulan_ini'] }}</h2>
                    </div>
                    <i class="bi bi-calendar" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Minggu Ini</h6>
                        <h2 class="mb-0">{{ $data['email_minggu_ini'] }}</h2>
                    </div>
                    <i class="bi bi-calendar2-week" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Rata-rata/Hari</h6>
                        <h2 class="mb-0">{{ $data['email_bulan_ini'] > 0 ? round($data['email_bulan_ini'] / now()->day) : 0 }}</h2>
                    </div>
                    <i class="bi bi-graph-up" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Email Statistics</h5>
            </div>
            <div class="card-body">
                <canvas id="emailChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-list"></i> Email Terbaru (Top 5)</h5>
            </div>
            <div class="card-body">
                @if($data['recent_emails']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Subject</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_emails'] as $email)
                            <tr>
                                <td><strong>{{ Str::limit($email->pelanggan->nama ?? '-', 12) }}</strong></td>
                                <td>{{ Str::limit($email->subject, 15) }}</td>
                                <td><small>{{ $email->waktu_kirim->format('d M H:i') }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0">Belum ada data email.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endif

<!-- MARKETING 4 - ACTIVITIES MANAGEMENT DASHBOARD -->
@if($data['role'] === 'marketing4')
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Aktivitas</h6>
                        <h2 class="mb-0">{{ $data['total_aktivitas'] }}</h2>
                    </div>
                    <i class="bi bi-calendar" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Direncanakan</h6>
                        <h2 class="mb-0">{{ $data['aktivitas_direncanakan'] }}</h2>
                    </div>
                    <i class="bi bi-clock" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Selesai</h6>
                        <h2 class="mb-0">{{ $data['aktivitas_selesai'] }}</h2>
                    </div>
                    <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Completion Rate</h6>
                        <h2 class="mb-0">{{ $data['total_aktivitas'] > 0 ? round(($data['aktivitas_selesai'] / $data['total_aktivitas']) * 100) : 0 }}%</h2>
                    </div>
                    <i class="bi bi-percent" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Status Aktivitas</h5>
            </div>
            <div class="card-body">
                <canvas id="aktivitasChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-list"></i> Aktivitas Mendatang (Top 5)</h5>
            </div>
            <div class="card-body">
                @if($data['upcoming_activities']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['upcoming_activities'] as $activity)
                            <tr>
                                <td><strong>{{ Str::limit($activity->judul, 12) }}</strong></td>
                                <td><span class="badge {{ $activity->getJenisBadgeClass() }}">{{ Str::limit($activity->jenis_aktivitas, 10) }}</span></td>
                                <td><small>{{ $activity->tanggal_jadwal->format('d M') }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0">Belum ada aktivitas terjadwal.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endif

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Chart Configuration
    Chart.defaults.font.family = "'Nunito', sans-serif";
    Chart.defaults.color = '#858796';

    @if($data['role'] === 'admin')
        // Admin - Leads Bar Chart
        new Chart(document.getElementById('leadsChart'), {
            type: 'bar',
            data: {
                labels: @json($data['leads_chart']['labels']),
                datasets: [{
                    label: 'Jumlah Lead',
                    data: @json($data['leads_chart']['data']),
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.8)',
                        'rgba(237, 100, 166, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(0, 242, 254, 0.8)'
                    ],
                    borderColor: [
                        'rgb(102, 126, 234)',
                        'rgb(118, 75, 162)',
                        'rgb(237, 100, 166)',
                        'rgb(79, 172, 254)',
                        'rgb(0, 242, 254)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Admin - Pelanggan Pie Chart
        new Chart(document.getElementById('aktivitasChart'), {
            type: 'doughnut',
            data: {
                labels: @json($data['aktivitas_chart']['labels']),
                datasets: [{
                    data: @json($data['aktivitas_chart']['data']),
                    backgroundColor: [
                        'rgba(243, 156, 18, 0.8)',
                        'rgba(39, 174, 96, 0.8)'
                    ],
                    borderColor: [
                        'rgb(243, 156, 18)',
                        'rgb(39, 174, 96)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15 }
                    }
                }
            }
        });

        // Admin - Email Bar Chart
        new Chart(document.getElementById('emailChart'), {
            type: 'bar',
            data: {
                labels: @json($data['email_chart']['labels']),
                datasets: [{
                    label: 'Jumlah Email',
                    data: @json($data['email_chart']['data']),
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(93, 173, 226, 0.8)'
                    ],
                    borderColor: [
                        'rgb(52, 152, 219)',
                        'rgb(23, 162, 184)',
                        'rgb(93, 173, 226)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    @endif

    @if($data['role'] === 'marketing1')
        // Marketing 1 - Leads Bar Chart
        new Chart(document.getElementById('leadsChart'), {
            type: 'bar',
            data: {
                labels: @json($data['leads_chart']['labels']),
                datasets: [{
                    label: 'Jumlah Lead',
                    data: @json($data['leads_chart']['data']),
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.8)',
                        'rgba(237, 100, 166, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(0, 242, 254, 0.8)'
                    ],
                    borderColor: [
                        'rgb(102, 126, 234)',
                        'rgb(118, 75, 162)',
                        'rgb(237, 100, 166)',
                        'rgb(79, 172, 254)',
                        'rgb(0, 242, 254)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    @endif

    @if($data['role'] === 'marketing2')
        // Marketing 2 - Pelanggan Doughnut Chart
        new Chart(document.getElementById('pelangganChart'), {
            type: 'doughnut',
            data: {
                labels: @json($data['pelanggan_chart']['labels']),
                datasets: [{
                    data: @json($data['pelanggan_chart']['data']),
                    backgroundColor: [
                        'rgba(39, 174, 96, 0.8)',
                        'rgba(149, 165, 166, 0.8)'
                    ],
                    borderColor: [
                        'rgb(39, 174, 96)',
                        'rgb(149, 165, 166)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15 }
                    }
                }
            }
        });
    @endif

    @if($data['role'] === 'marketing3')
        // Marketing 3 - Email Bar Chart
        new Chart(document.getElementById('emailChart'), {
            type: 'bar',
            data: {
                labels: @json($data['email_chart']['labels']),
                datasets: [{
                    label: 'Jumlah Email',
                    data: @json($data['email_chart']['data']),
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(93, 173, 226, 0.8)'
                    ],
                    borderColor: [
                        'rgb(52, 152, 219)',
                        'rgb(23, 162, 184)',
                        'rgb(93, 173, 226)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    @endif

    @if($data['role'] === 'marketing4')
        // Marketing 4 - Aktivitas Doughnut Chart
        new Chart(document.getElementById('aktivitasChart'), {
            type: 'doughnut',
            data: {
                labels: @json($data['aktivitas_chart']['labels']),
                datasets: [{
                    data: @json($data['aktivitas_chart']['data']),
                    backgroundColor: [
                        'rgba(243, 156, 18, 0.8)',
                        'rgba(39, 174, 96, 0.8)'
                    ],
                    borderColor: [
                        'rgb(243, 156, 18)',
                        'rgb(39, 174, 96)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15 }
                    }
                }
            }
        });
    @endif
</script>
@endpush
