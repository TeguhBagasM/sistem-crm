@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-person-check"></i> Detail Pelanggan</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Contact Management</a></li>
            <li class="breadcrumb-item active">Detail Pelanggan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person"></i> {{ $pelanggan->nama }}</h5>
                    <div>
                        <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('pelanggan.destroy', $pelanggan) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
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
                <div class="customer-info p-3 bg-light rounded mb-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-person-circle"></i> Nama:</strong><br>
                                <span class="text-primary">{{ $pelanggan->nama }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-telephone"></i> No. Telepon:</strong><br>
                                <span class="text-primary">{{ $pelanggan->no_telepon }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-0">
                                <strong><i class="bi bi-envelope"></i> Email:</strong><br>
                                <span class="text-primary">{{ $pelanggan->email ?? '-' }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">
                                <strong><i class="bi bi-building"></i> Perusahaan:</strong><br>
                                <span class="text-primary">{{ $pelanggan->perusahaan ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="mb-0">
                                <strong><i class="bi bi-geo-alt"></i> Alamat:</strong><br>
                                <span class="text-primary">{{ $pelanggan->alamat ?? '-' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email History Section -->
                @if($pelanggan->riwayatEmail->count() > 0)
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-envelope-open"></i> Riwayat Email ({{ $pelanggan->riwayatEmail->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Subjek</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pelanggan->riwayatEmail as $email)
                                    <tr>
                                        <td><small>{{ $email->created_at->format('d M Y H:i') }}</small></td>
                                        <td><small>{{ Str::limit($email->subjek, 40) }}</small></td>
                                        <td>
                                            <a href="{{ route('emails.show', $email) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Activities Section -->
                @if($pelanggan->jadwalAktivitas->count() > 0)
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h6 class="mb-0"><i class="bi bi-calendar-event"></i> Aktivitas Terjadwal ({{ $pelanggan->jadwalAktivitas->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Aktivitas</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pelanggan->jadwalAktivitas as $aktivitas)
                                    <tr>
                                        <td><small>{{ $aktivitas->tanggal->format('d M Y') }}</small></td>
                                        <td><small>{{ Str::limit($aktivitas->deskripsi, 40) }}</small></td>
                                        <td>
                                            <span class="badge {{ $aktivitas->status == 'selesai' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($aktivitas->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('aktivitas.show', $aktivitas) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Customer Info Card -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi Pelanggan</h6>
                <table class="table table-sm">
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="badge {{ $pelanggan->status_pelanggan == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst(str_replace('_', ' ', $pelanggan->status_pelanggan)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Pemilik Data</strong></td>
                        <td>{{ $pelanggan->pemilik->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td><small>{{ $pelanggan->created_at->format('d M Y H:i') }}</small></td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate</strong></td>
                        <td><small>{{ $pelanggan->updated_at->format('d M Y H:i') }}</small></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Lead Source Card -->
        @if($pelanggan->calonPelanggan)
        <div class="card mb-3 bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-person-badge"></i> Asal Lead</h6>
                <p class="small mb-2"><strong>{{ $pelanggan->calonPelanggan->nama }}</strong></p>
                <p class="small mb-2">Sumber: <span class="badge bg-secondary">{{ $pelanggan->calonPelanggan->sumber }}</span></p>
                <p class="small mb-2">Status: <span class="badge bg-success">{{ ucfirst(str_replace('_', ' ', $pelanggan->calonPelanggan->status_lead)) }}</span></p>
                <hr>
                <a href="{{ route('leads.show', $pelanggan->calonPelanggan) }}" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-eye"></i> Lihat Lead
                </a>
            </div>
        </div>
        @endif

        <!-- Quick Actions Card -->
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-lightning"></i> Aksi Cepat</h6>
                <a href="{{ route('emails.create') }}" class="btn btn-sm btn-light w-100 mb-2">
                    <i class="bi bi-envelope-plus"></i> Kirim Email
                </a>
                <a href="{{ route('aktivitas.create') }}" class="btn btn-sm btn-light w-100">
                    <i class="bi bi-calendar-plus"></i> Buat Aktivitas
                </a>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="card">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-bar-chart"></i> Statistik</h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-3">
                            <p class="h4 mb-0 text-primary">{{ $pelanggan->riwayatEmail->count() }}</p>
                            <small class="text-muted">Email Tercatat</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <p class="h4 mb-0 text-warning">{{ $pelanggan->jadwalAktivitas->count() }}</p>
                            <small class="text-muted">Aktivitas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
