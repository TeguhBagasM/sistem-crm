@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-person-plus"></i> Tambah User Baru</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
            <li class="breadcrumb-item active">Tambah User</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                               id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="marketing1" {{ old('role') == 'marketing1' ? 'selected' : '' }}>Marketing 1 (Lead Management)</option>
                            <option value="marketing2" {{ old('role') == 'marketing2' ? 'selected' : '' }}>Marketing 2 (Contact Management)</option>
                            <option value="marketing3" {{ old('role') == 'marketing3' ? 'selected' : '' }}>Marketing 3 (Email Management)</option>
                            <option value="marketing4" {{ old('role') == 'marketing4' ? 'selected' : '' }}>Marketing 4 (Activities Management)</option>
                        </select>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
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
                    <strong>Admin:</strong> Akses penuh ke semua fitur
                </p>
                <p class="small text-muted mb-2">
                    <strong>Marketing 1:</strong> Akses Lead Management
                </p>
                <p class="small text-muted mb-2">
                    <strong>Marketing 2:</strong> Akses Contact Management
                </p>
                <p class="small text-muted mb-2">
                    <strong>Marketing 3:</strong> Akses Email Management
                </p>
                <p class="small text-muted mb-0">
                    <strong>Marketing 4:</strong> Akses Activities Management
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
