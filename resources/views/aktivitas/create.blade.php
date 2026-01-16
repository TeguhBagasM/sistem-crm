@extends('layouts.app')

@section('title', 'Tambah Aktivitas')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-calendar-plus"></i> Tambah Aktivitas Baru</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('aktivitas.index') }}">Calendar & Activities</a></li>
            <li class="breadcrumb-item active">Tambah Aktivitas</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-calendar"></i> Formulir Aktivitas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('aktivitas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="judul" class="form-label">
                            Judul Aktivitas <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                               id="judul" name="judul" value="{{ old('judul') }}"
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
                                    <option value="email" {{ old('jenis_aktivitas') == 'email' ? 'selected' : '' }}>
                                        📧 Email Campaign
                                    </option>
                                    <option value="followup" {{ old('jenis_aktivitas') == 'followup' ? 'selected' : '' }}>
                                        📞 Follow-up Client
                                    </option>
                                    <option value="konten" {{ old('jenis_aktivitas') == 'konten' ? 'selected' : '' }}>
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
                                       value="{{ old('tanggal_jadwal', now()->format('Y-m-d')) }}" required>
                                @error('tanggal_jadwal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                                        {{ old('id_pelanggan') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama }} - {{ $customer->perusahaan ?? 'No Company' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika aktivitas tidak terkait pelanggan tertentu</small>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">
                            Deskripsi Aktivitas
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="6"
                                  placeholder="Jelaskan detail aktivitas yang akan dilakukan...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Aktivitas
                        </button>
                        <a href="{{ route('aktivitas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi</h6>
                <p class="small text-muted mb-2">
                    <strong>Jenis Aktivitas:</strong>
                </p>
                <ul class="small text-muted">
                    <li><strong>Email:</strong> Campaign email marketing</li>
                    <li><strong>Follow-up:</strong> Menghubungi client</li>
                    <li><strong>Konten:</strong> Pembuatan konten marketing</li>
                </ul>
                <p class="small text-muted mb-0">
                    <strong>Status:</strong> Aktivitas baru akan berstatus "Direncanakan"
                </p>
            </div>
        </div>

        <div class="card bg-warning">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-lightbulb"></i> Tips</h6>
                <ul class="small mb-0">
                    <li>Gunakan judul yang jelas dan spesifik</li>
                    <li>Set reminder di calendar Anda</li>
                    <li>Pastikan tanggal realistis</li>
                    <li>Update status setelah selesai</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
