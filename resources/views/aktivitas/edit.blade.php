@extends('layouts.app')

@section('title', 'Edit Aktivitas')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-pencil-square"></i> Edit Aktivitas</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('aktivitas.index') }}">Calendar & Activities</a></li>
            <li class="breadcrumb-item active">Edit Aktivitas</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-calendar"></i> Edit Formulir Aktivitas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('aktivitas.update', $aktivitas) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="judul" class="form-label">
                            Judul Aktivitas <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                               id="judul" name="judul" value="{{ old('judul', $aktivitas->judul) }}"
                               placeholder="Contoh: Follow-up Proposal PT. ABC" required>
                        @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_aktivitas" class="form-label">
                                    Jenis Aktivitas <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('jenis_aktivitas') is-invalid @enderror"
                                        id="jenis_aktivitas" name="jenis_aktivitas" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="email" {{ old('jenis_aktivitas', $aktivitas->jenis_aktivitas) == 'email' ? 'selected' : '' }}>
                                        📧 Email Campaign
                                    </option>
                                    <option value="followup" {{ old('jenis_aktivitas', $aktivitas->jenis_aktivitas) == 'followup' ? 'selected' : '' }}>
                                        📞 Follow-up Client
                                    </option>
                                    <option value="konten" {{ old('jenis_aktivitas', $aktivitas->jenis_aktivitas) == 'konten' ? 'selected' : '' }}>
                                        📝 Konten Marketing
                                    </option>
                                </select>
                                @error('jenis_aktivitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_jadwal" class="form-label">
                                    Tanggal Jadwal <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('tanggal_jadwal') is-invalid @enderror"
                                       id="tanggal_jadwal" name="tanggal_jadwal"
                                       value="{{ old('tanggal_jadwal', $aktivitas->tanggal_jadwal->format('Y-m-d')) }}" required>
                                @error('tanggal_jadwal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_aktivitas" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status_aktivitas') is-invalid @enderror"
                                id="status_aktivitas" name="status_aktivitas" required>
                            <option value="direncanakan" {{ old('status_aktivitas', $aktivitas->status_aktivitas) == 'direncanakan' ? 'selected' : '' }}>
                                Direncanakan
                            </option>
                            <option value="selesai" {{ old('status_aktivitas', $aktivitas->status_aktivitas) == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                        @error('status_aktivitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_pelanggan" class="form-label">
                            Pelanggan (Opsional)
                        </label>
                        <select class="form-select @error('id_pelanggan') is-invalid @enderror"
                                id="id_pelanggan" name="id_pelanggan">
                            <option value="">-- Tidak Ada / Aktivitas Umum --</option>
                            @foreach($pelanggan as $customer)
                                <option value="{{ $customer->id }}"
                                        {{ old('id_pelanggan', $aktivitas->id_pelanggan) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama }} - {{ $customer->perusahaan ?? 'No Company' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">
                            Deskripsi Aktivitas
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="6"
                                  placeholder="Jelaskan detail aktivitas yang akan dilakukan...">{{ old('deskripsi', $aktivitas->deskripsi) }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Aktivitas
                        </button>
                        <a href="{{ route('aktivitas.show', $aktivitas) }}" class="btn btn-secondary">
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
                <p class="small mb-2">
                    <strong>Dibuat:</strong> {{ $aktivitas->created_at->format('d M Y H:i') }}
                </p>
                <p class="small mb-2">
                    <strong>Terakhir Update:</strong> {{ $aktivitas->updated_at->format('d M Y H:i') }}
                </p>
                <p class="small mb-0">
                    <strong>Dibuat Oleh:</strong> {{ $aktivitas->pembuat->name }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
