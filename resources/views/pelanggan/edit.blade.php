@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-pencil-square"></i> Edit Pelanggan</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Contact Management</a></li>
            <li class="breadcrumb-item active">Edit Pelanggan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Form Edit Pelanggan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $pelanggan->email) }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                               id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pelanggan->no_telepon) }}" required>
                        @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="perusahaan" class="form-label">Perusahaan</label>
                        <input type="text" class="form-control @error('perusahaan') is-invalid @enderror"
                               id="perusahaan" name="perusahaan" value="{{ old('perusahaan', $pelanggan->perusahaan) }}">
                        @error('perusahaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_pelanggan" class="form-label">Status Pelanggan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_pelanggan') is-invalid @enderror"
                                id="status_pelanggan" name="status_pelanggan" required>
                            <option value="aktif" {{ old('status_pelanggan', $pelanggan->status_pelanggan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status_pelanggan', $pelanggan->status_pelanggan) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('pelanggan.show', $pelanggan) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi</h6>
                <p class="small text-muted mb-2">
                    <strong>Edit Data:</strong> Ubah informasi pelanggan sesuai kebutuhan
                </p>
                <p class="small text-muted mb-2">
                    <strong>Status:</strong> Tentukan apakah pelanggan sedang aktif atau tidak
                </p>
                <hr>
                <p class="small text-muted mb-0">
                    <strong>Catatan:</strong> Semua perubahan akan disimpan otomatis dengan mencatat waktu update
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
