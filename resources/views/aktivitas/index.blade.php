@extends('layouts.app')

@section('title', 'Calendar & Activities')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-calendar-event"></i> Calendar & Activities</h2>
        <p class="text-muted mb-0">Kelola jadwal aktivitas dan follow-up</p>
    </div>
    <a href="{{ route('aktivitas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Aktivitas
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Aktivitas</h6>
                        <h2 class="mb-0">{{ $totalAktivitas }}</h2>
                    </div>
                    <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Direncanakan</h6>
                        <h2 class="mb-0">{{ $aktivitasDirencanakan }}</h2>
                    </div>
                    <i class="bi bi-hourglass-split" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Selesai</h6>
                        <h2 class="mb-0">{{ $aktivitasSelesai }}</h2>
                    </div>
                    <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Hari Ini</h6>
                        <h2 class="mb-0">{{ $aktivitasHariIni }}</h2>
                    </div>
                    <i class="bi bi-calendar-day" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('aktivitas.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="jenis_aktivitas" class="form-label">Jenis Aktivitas</label>
                <select class="form-select" id="jenis_aktivitas" name="jenis_aktivitas">
                    <option value="">Semua Jenis</option>
                    <option value="email" {{ request('jenis_aktivitas') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="followup" {{ request('jenis_aktivitas') == 'followup' ? 'selected' : '' }}>Follow-up</option>
                    <option value="konten" {{ request('jenis_aktivitas') == 'konten' ? 'selected' : '' }}>Konten</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="status_aktivitas" class="form-label">Status</label>
                <select class="form-select" id="status_aktivitas" name="status_aktivitas">
                    <option value="">Semua Status</option>
                    <option value="direncanakan" {{ request('status_aktivitas') == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                    <option value="selesai" {{ request('status_aktivitas') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari"
                       value="{{ request('tanggal_dari') }}">
            </div>
            <div class="col-md-2">
                <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai"
                       value="{{ request('tanggal_sampai') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Activities List -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Judul</th>
                                <th width="15%">Jenis</th>
                                <th width="15%">Tanggal</th>
                                <th width="15%">Pelanggan</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktivitas as $activity)
                            <tr class="{{ $activity->tanggal_jadwal->isToday() ? 'table-warning' : '' }}">
                                <td>{{ $loop->iteration + ($aktivitas->currentPage() - 1) * $aktivitas->perPage() }}</td>
                                <td>
                                    <strong>{{ $activity->judul }}</strong>
                                    @if($activity->tanggal_jadwal->isToday())
                                        <span class="badge bg-danger ms-1">Hari Ini!</span>
                                    @elseif($activity->tanggal_jadwal->isPast() && $activity->status_aktivitas == 'direncanakan')
                                        <span class="badge bg-warning ms-1">Terlambat</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ Str::limit($activity->deskripsi, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $activity->getJenisBadgeClass() }}">
                                        {{ ucfirst($activity->jenis_aktivitas) }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-calendar"></i> {{ $activity->tanggal_jadwal->format('d M Y') }}<br>
                                    <small class="text-muted">{{ $activity->tanggal_jadwal->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($activity->pelanggan)
                                        {{ $activity->pelanggan->nama }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $activity->getStatusBadgeClass() }}">
                                        {{ ucfirst($activity->status_aktivitas) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if($activity->status_aktivitas == 'direncanakan')
                                        <form action="{{ route('aktivitas.update-status', $activity) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_aktivitas" value="selesai">
                                            <button type="submit" class="btn btn-success" title="Tandai Selesai">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <a href="{{ route('aktivitas.show', $activity) }}" class="btn btn-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('aktivitas.edit', $activity) }}" class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('aktivitas.destroy', $activity) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus aktivitas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Belum ada aktivitas terjadwal</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $aktivitas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
