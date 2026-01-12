@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-people"></i> Tambah Pelanggan Baru</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Contact Management</a></li>
            <li class="breadcrumb-item active">Tambah Pelanggan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf

                    @if($leads->count() > 0)
                    <div class="mb-3">
                        <label for="id_calon_pelanggan" class="form-label">Konversi dari Lead (Opsional)</label>
                        <select class="form-select @error('id_calon_pelanggan') is-invalid @enderror"
                                id="id_calon_pelanggan" name="id_calon_pelanggan">
                            <option value="">-- Pilih Lead atau Isi Manual --</option>
                            @foreach($leads as $lead)
                            <option value="{{ $lead->id }}"
                                    data-nama="{{ $lead->nama }}"
                                    data-email="{{ $lead->email }}"
                                    data-telepon="{{ $lead->no_telepon }}">
                                {{ $lead->nama }} - {{ $lead->no_telepon }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_calon_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama') }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                               id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                        @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="perusahaan" class="form-label">Perusahaan</label>
                        <input type="text" class="form-control @error('perusahaan') is-invalid @enderror"
                               id="perusahaan" name="perusahaan" value="{{ old('perusahaan') }}">
                        @error('perusahaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_pelanggan" class="form-label">Status Pelanggan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_pelanggan') is-invalid @enderror"
                                id="status_pelanggan" name="status_pelanggan" required>
                            <option value="aktif" {{ old('status_pelanggan') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status_pelanggan') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
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
                    <strong>Konversi Lead:</strong> Pilih lead yang sudah qualified untuk otomatis mengisi data
                </p>
                <p class="small text-muted mb-0">
                    <strong>Status:</strong> Pelanggan baru default berstatus "Aktif"
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('id_calon_pelanggan').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    if (this.value) {
        document.getElementById('nama').value = selected.dataset.nama || '';
        document.getElementById('email').value = selected.dataset.email || '';
        document.getElementById('no_telepon').value = selected.dataset.telepon || '';
    }
});
</script>
@endpush
@endsection
