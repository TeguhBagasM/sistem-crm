@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h2>Dashboard</h2>
    <p class="text-muted">Selamat datang, {{ $user->name }}!</p>
</div>

<div class="row mb-4">
    @if($user->hasAccess(['marketing1']))
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
    @endif

    @if($user->hasAccess(['marketing2']))
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
    @endif

    @if($user->hasAccess(['marketing3']))
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
    @endif

    @if($user->hasAccess(['marketing4']))
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
    @endif
</div>

<div class="row">
    @if($user->hasAccess(['marketing1']) && isset($data['recent_leads']))
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-plus text-primary"></i> Lead Terbaru</h5>
            </div>
            <div class="card-body">
                @if($data['recent_leads']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                <td>{{ $lead->nama }}</td>
                                <td><span class="badge bg-secondary">{{ $lead->sumber }}</span></td>
                                <td><span class="badge {{ $lead->getStatusBadgeClass() }}">{{ $lead->status_lead }}</span></td>
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
    @endif

    @if($user->hasAccess(['marketing4']) && isset($data['upcoming_activities']))
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-calendar text-warning"></i> Aktivitas Mendatang</h5>
            </div>
            <div class="card-body">
                @if($data['upcoming_activities']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                <td>{{ $activity->judul }}</td>
                                <td><span class="badge {{ $activity->getJenisBadgeClass() }}">{{ $activity->jenis_aktivitas }}</span></td>
                                <td>{{ $activity->tanggal_jadwal->format('d M Y') }}</td>
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
    @endif
</div>
@endsection
