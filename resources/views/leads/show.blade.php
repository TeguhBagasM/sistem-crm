@extends('layouts.app')

@section('title', 'Detail Lead')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-person-badge"></i> Detail Lead</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Lead Management</a></li>
            <li class="breadcrumb-item active">Detail Lead</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person"></i> {{ $lead->nama }}</h5>
                    <div>
                        <a href="{{ route('leads.edit', $lead) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus lead ini?')">
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
                <div class="lead-info mb-4 p-3 bg-light rounded">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-person-circle"></i> Nama:</strong><br>
                                <span class="text-primary">{{ $lead->nama }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-telephone"></i> No. Telepon:</strong><br>
                                <span class="text-primary">{{ $lead->no_telepon }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-envelope"></i> Email:</strong><br>
                                <span class="text-primary">{{ $lead->email ?? '-' }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-tag"></i> Sumber:</strong><br>
                                <span class="badge bg-secondary">{{ $lead->sumber }}</span>
                            </p>
                        </div>
                    </div>

                    @if($lead->alamat)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="mb-0">
                                <strong><i class="bi bi-geo-alt"></i> Alamat:</strong><br>
                                <span class="text-primary">{{ $lead->alamat }}</span>
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                @if($lead->catatan)
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-sticky"></i> Catatan</h6>
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $lead->catatan }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi Lead</h6>
                <table class="table table-sm">
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="badge {{ $lead->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $lead->status_lead)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat Oleh</strong></td>
                        <td>{{ $lead->pembuatData->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td>{{ $lead->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate</strong></td>
                        <td>{{ $lead->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-warning">
                <h6 class="mb-0"><i class="bi bi-arrow-left-right"></i> Ubah Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('leads.update-status', $lead) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select class="form-select @error('status_lead') is-invalid @enderror"
                                name="status_lead" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="baru" {{ $lead->status_lead == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="dihubungi" {{ $lead->status_lead == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
                            <option value="qualified" {{ $lead->status_lead == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="gagal" {{ $lead->status_lead == 'gagal' ? 'selected' : '' }}>Gagal</option>
                        </select>
                        @error('status_lead')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i> Perbarui Status
                    </button>
                </form>
            </div>
        </div>

        @if($lead->pelanggan)
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-check-circle"></i> Lead Sudah Dikonversi</h6>
                <p class="small mb-2">Lead ini telah dikonversi menjadi pelanggan:</p>
                <p class="mb-2"><strong>{{ $lead->pelanggan->nama }}</strong></p>
                <p class="mb-0 small">📱 {{ $lead->pelanggan->no_telepon }}</p>
                <hr class="bg-white">
                <a href="{{ route('pelanggan.show', $lead->pelanggan) }}" class="btn btn-sm btn-light w-100">
                    <i class="bi bi-eye"></i> Lihat Pelanggan
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
