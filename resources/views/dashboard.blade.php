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
            <div class="card-body" id="leadsChart"></div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Pelanggan Status</h5>
            </div>
            <div class="card-body" id="pelangganChart"></div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Email Stats</h5>
            </div>
            <div class="card-body" id="emailChart"></div>
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
            <div class="card-body" id="leadsChart"></div>
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
            <div class="card-body" id="pelangganChart"></div>
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
            <div class="card-body" id="emailChart"></div>
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
            <div class="card-body" id="aktivitasChart"></div>
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
<script>
    @if($data['role'] === 'admin')
        // Admin Charts
        const leadsData = {
            labels: @json($data['leads_chart']['labels']),
            data: @json($data['leads_chart']['data']),
        };

        const leadsCtx = document.getElementById('leadsChart');
        let leadsHtml = '<div style="display: flex; gap: 8px; align-items: flex-end; height: 200px;">';
        const maxLeads = Math.max(...leadsData.data);
        const leadColors = ['#667eea', '#764ba2', '#f093fb', '#4facfe', '#00f2fe'];

        leadsData.data.forEach((value, index) => {
            const height = (value / maxLeads) * 160;
            leadsHtml += `
                <div style="flex: 1; text-align: center;">
                    <div style="background: ${leadColors[index % leadColors.length]}; height: ${height}px; border-radius: 6px; margin-bottom: 8px;"></div>
                    <div style="font-size: 0.8rem; font-weight: 600;">${value}</div>
                    <div style="font-size: 0.65rem; color: #666;">${leadsData.labels[index]}</div>
                </div>
            `;
        });
        leadsHtml += '</div>';
        leadsCtx.innerHTML = leadsHtml;

        // Pelanggan Pie
        const pelangganData = {
            labels: @json($data['pelanggan_chart']['labels']),
            data: @json($data['pelanggan_chart']['data']),
        };

        const pelangganCtx = document.getElementById('pelangganChart');
        const pelangganColors = ['#27ae60', '#95a5a6'];
        let pelangganHtml = '<div style="padding: 15px;">';
        pelangganData.data.forEach((value, index) => {
            const percentage = pelangganData.data.reduce((a,b) => a+b) > 0
                ? ((value / pelangganData.data.reduce((a,b) => a+b)) * 100).toFixed(0)
                : 0;
            pelangganHtml += `
                <div style="margin: 10px 0; font-size: 0.9rem;">
                    <span style="display: inline-block; width: 14px; height: 14px; background: ${pelangganColors[index]}; border-radius: 50%; margin-right: 8px;"></span>
                    <strong>${pelangganData.labels[index]}:</strong> ${value} (${percentage}%)
                </div>
            `;
        });
        pelangganHtml += '</div>';
        pelangganCtx.innerHTML = pelangganHtml;

        // Email Bar
        const emailData = {
            labels: @json($data['email_chart']['labels']),
            data: @json($data['email_chart']['data']),
        };

        const emailCtx = document.getElementById('emailChart');
        let emailHtml = '<div style="display: flex; gap: 10px; align-items: flex-end; height: 200px;">';
        const maxEmail = Math.max(...emailData.data);
        const emailColors = ['#3498db', '#17a2b8', '#5dade2'];

        emailData.data.forEach((value, index) => {
            const height = (value / maxEmail) * 160;
            emailHtml += `
                <div style="flex: 1; text-align: center;">
                    <div style="background: ${emailColors[index]}; height: ${height}px; border-radius: 6px; margin-bottom: 8px;"></div>
                    <div style="font-size: 0.8rem; font-weight: 600;">${value}</div>
                    <div style="font-size: 0.65rem; color: #666;">${emailData.labels[index]}</div>
                </div>
            `;
        });
        emailHtml += '</div>';
        emailCtx.innerHTML = emailHtml;
    @endif

    @if($data['role'] === 'marketing1')
        // Marketing1 - Leads Chart
        const leadsData = {
            labels: @json($data['leads_chart']['labels']),
            data: @json($data['leads_chart']['data']),
        };

        const leadsCtx = document.getElementById('leadsChart');
        let leadsHtml = '<div style="display: flex; gap: 8px; align-items: flex-end; height: 220px;">';
        const maxLeads = Math.max(...leadsData.data);
        const leadColors = ['#667eea', '#764ba2', '#f093fb', '#4facfe', '#00f2fe'];

        leadsData.data.forEach((value, index) => {
            const height = (value / maxLeads) * 180;
            leadsHtml += `
                <div style="flex: 1; text-align: center;">
                    <div style="background: ${leadColors[index % leadColors.length]}; height: ${height}px; border-radius: 6px; margin-bottom: 8px;"></div>
                    <div style="font-size: 0.8rem; font-weight: 600;">${value}</div>
                    <div style="font-size: 0.65rem; color: #666;">${leadsData.labels[index]}</div>
                </div>
            `;
        });
        leadsHtml += '</div>';
        leadsCtx.innerHTML = leadsHtml;
    @endif

    @if($data['role'] === 'marketing2')
        // Marketing2 - Pelanggan Chart
        const pelangganData = {
            labels: @json($data['pelanggan_chart']['labels']),
            data: @json($data['pelanggan_chart']['data']),
        };

        const pelangganCtx = document.getElementById('pelangganChart');
        const pelangganColors = ['#27ae60', '#95a5a6'];
        let pelangganHtml = '<div style="padding: 25px; text-align: center;">';
        pelangganData.data.forEach((value, index) => {
            const percentage = pelangganData.data.reduce((a,b) => a+b) > 0
                ? ((value / pelangganData.data.reduce((a,b) => a+b)) * 100).toFixed(0)
                : 0;
            pelangganHtml += `
                <div style="margin: 15px 0; font-size: 1rem;">
                    <span style="display: inline-block; width: 18px; height: 18px; background: ${pelangganColors[index]}; border-radius: 50%; margin-right: 10px;"></span>
                    <strong>${pelangganData.labels[index]}:</strong> ${value} (${percentage}%)
                </div>
            `;
        });
        pelangganHtml += '</div>';
        pelangganCtx.innerHTML = pelangganHtml;
    @endif

    @if($data['role'] === 'marketing3')
        // Marketing3 - Email Chart
        const emailData = {
            labels: @json($data['email_chart']['labels']),
            data: @json($data['email_chart']['data']),
        };

        const emailCtx = document.getElementById('emailChart');
        let emailHtml = '<div style="display: flex; gap: 10px; align-items: flex-end; height: 220px;">';
        const maxEmail = Math.max(...emailData.data);
        const emailColors = ['#3498db', '#17a2b8', '#5dade2'];

        emailData.data.forEach((value, index) => {
            const height = (value / maxEmail) * 180;
            emailHtml += `
                <div style="flex: 1; text-align: center;">
                    <div style="background: ${emailColors[index]}; height: ${height}px; border-radius: 6px; margin-bottom: 8px;"></div>
                    <div style="font-size: 0.8rem; font-weight: 600;">${value}</div>
                    <div style="font-size: 0.65rem; color: #666;">${emailData.labels[index]}</div>
                </div>
            `;
        });
        emailHtml += '</div>';
        emailCtx.innerHTML = emailHtml;
    @endif

    @if($data['role'] === 'marketing4')
        // Marketing4 - Aktivitas Pie
        const aktivitasData = {
            labels: @json($data['aktivitas_chart']['labels']),
            data: @json($data['aktivitas_chart']['data']),
        };

        const aktivitasCtx = document.getElementById('aktivitasChart');
        const aktivitasColors = ['#f39c12', '#27ae60'];
        let aktivitasHtml = '<div style="padding: 25px; text-align: center;">';
        aktivitasData.data.forEach((value, index) => {
            const percentage = aktivitasData.data.reduce((a,b) => a+b) > 0
                ? ((value / aktivitasData.data.reduce((a,b) => a+b)) * 100).toFixed(0)
                : 0;
            aktivitasHtml += `
                <div style="margin: 15px 0; font-size: 1rem;">
                    <span style="display: inline-block; width: 18px; height: 18px; background: ${aktivitasColors[index]}; border-radius: 50%; margin-right: 10px;"></span>
                    <strong>${aktivitasData.labels[index]}:</strong> ${value} (${percentage}%)
                </div>
            `;
        });
        aktivitasHtml += '</div>';
        aktivitasCtx.innerHTML = aktivitasHtml;
    @endif
</script>
@endpush
