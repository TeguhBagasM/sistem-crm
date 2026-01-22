@extends('layouts.app')

@section('title', 'Detail Aktivitas')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-calendar-event"></i> Detail Aktivitas</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('aktivitas.index') }}">Calendar & Activities</a></li>
            <li class="breadcrumb-item active">Detail Aktivitas</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> {{ $aktivitas->judul }}</h5>
                    <div>
                        <a href="{{ route('aktivitas.edit', $aktivitas) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('aktivitas.destroy', $aktivitas) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus aktivitas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">INFORMASI AKTIVITAS</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Jenis</strong></td>
                                <td>
                                    <span class="badge {{ $aktivitas->getJenisBadgeClass() }}">
                                        {{ ucfirst($aktivitas->jenis_aktivitas) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>
                                    <span class="badge {{ $aktivitas->getStatusBadgeClass() }}">
                                        {{ ucfirst($aktivitas->status_aktivitas) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Jadwal</strong></td>
                                <td>
                                    <i class="bi bi-calendar"></i> {{ $aktivitas->tanggal_jadwal->format('d F Y') }}
                                    <br>
                                    <small class="text-muted">{{ $aktivitas->tanggal_jadwal->diffForHumans() }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat Oleh</strong></td>
                                <td>{{ $aktivitas->pembuat->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">PELANGGAN TERKAIT</h6>
                        @if($aktivitas->pelanggan)
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="bi bi-person"></i> {{ $aktivitas->pelanggan->nama }}</h6>
                            <p class="mb-1"><i class="bi bi-envelope"></i> {{ $aktivitas->pelanggan->email ?? 'Tidak ada email' }}</p>
                            <p class="mb-1"><i class="bi bi-telephone"></i> {{ $aktivitas->pelanggan->no_telepon }}</p>
                            @if($aktivitas->pelanggan->perusahaan)
                            <p class="mb-2"><i class="bi bi-building"></i> {{ $aktivitas->pelanggan->perusahaan }}</p>
                            @endif

                        </div>
                        @else
                        <div class="alert alert-secondary">
                            <i class="bi bi-info-circle"></i> Tidak terkait dengan pelanggan tertentu (Aktivitas umum)
                        </div>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="mt-4">
                    <h6 class="text-muted mb-3">DESKRIPSI AKTIVITAS</h6>
                    <div class="p-4 bg-light rounded" style="min-height: 200px; white-space: pre-wrap;">
                        {{ $aktivitas->deskripsi ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-clock-history"></i> Timeline</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-plus-circle text-success"></i>
                        <strong>Dibuat:</strong><br>
                        <small>{{ $aktivitas->created_at->format('d M Y, H:i') }}</small><br>
                        <small class="text-muted">{{ $aktivitas->created_at->diffForHumans() }}</small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-pencil text-warning"></i>
                        <strong>Terakhir Update:</strong><br>
                        <small>{{ $aktivitas->updated_at->format('d M Y, H:i') }}</small><br>
                        <small class="text-muted">{{ $aktivitas->updated_at->diffForHumans() }}</small>
                    </li>
                </ul>
            </div>
        </div>

        @if($aktivitas->tanggal_jadwal->isFuture() && $aktivitas->status_aktivitas == 'direncanakan')
        <div class="card bg-warning">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-bell"></i> Reminder</h6>
                <p class="mb-2">Aktivitas ini dijadwalkan:</p>
                <h5 class="mb-0">{{ $aktivitas->tanggal_jadwal->diffForHumans() }}</h5>
            </div>
        </div>
        @elseif($aktivitas->tanggal_jadwal->isPast() && $aktivitas->status_aktivitas == 'direncanakan')
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-exclamation-triangle"></i> Peringatan</h6>
                <p class="mb-0">Aktivitas ini sudah melewati tanggal jadwal. Segera update status!</p>
            </div>
        </div>
        @elseif($aktivitas->status_aktivitas == 'selesai')
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-check-circle"></i> Selesai</h6>
                <p class="mb-0">Aktivitas ini telah diselesaikan.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
