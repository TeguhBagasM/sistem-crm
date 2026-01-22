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

                    <!-- Data Pelanggan Section -->
                    <h6 class="mb-3"><i class="bi bi-info-circle"></i> Data Pelanggan</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                       id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $pelanggan->email) }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                       id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pelanggan->no_telepon) }}" required>
                                @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="perusahaan" class="form-label">Perusahaan</label>
                                <input type="text" class="form-control @error('perusahaan') is-invalid @enderror"
                                       id="perusahaan" name="perusahaan" value="{{ old('perusahaan', $pelanggan->perusahaan) }}">
                                @error('perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control @error('website') is-invalid @enderror"
                               id="website" name="website" value="{{ old('website', $pelanggan->website) }}" placeholder="https://...">
                        @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                  id="alamat" name="alamat" rows="3">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan_internal" class="form-label"><i class="bi bi-chat-left-text"></i> Catatan Internal</label>
                        <textarea class="form-control @error('catatan_internal') is-invalid @enderror"
                                  id="catatan_internal" name="catatan_internal" rows="2" placeholder="Catatan khusus untuk tim...">{{ old('catatan_internal', $pelanggan->catatan_internal) }}</textarea>
                        @error('catatan_internal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <!-- Kategorisasi Section -->
                    <h6 class="mb-3"><i class="bi bi-tag"></i> Kategorisasi</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori_pelanggan" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('kategori_pelanggan') is-invalid @enderror"
                                        id="kategori_pelanggan" name="kategori_pelanggan" required onchange="toggleKategoriInput()">
                                    <option value="">Pilih Kategori</option>
                                    <option value="retail" {{ old('kategori_pelanggan', $pelanggan->kategori_pelanggan) == 'retail' ? 'selected' : '' }}>Retail</option>
                                    <option value="wholesale" {{ old('kategori_pelanggan', $pelanggan->kategori_pelanggan) == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                    <option value="corporate" {{ old('kategori_pelanggan', $pelanggan->kategori_pelanggan) == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                    <option value="distributor" {{ old('kategori_pelanggan', $pelanggan->kategori_pelanggan) == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                    <option value="lainnya" {{ in_array(old('kategori_pelanggan', $pelanggan->kategori_pelanggan), ['lainnya', 'retail', 'wholesale', 'corporate', 'distributor']) === false ? 'selected' : '' }}>Lainnya (Ketik Manual)</option>
                                </select>
                                @error('kategori_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="kategori-input-group" class="mb-3" style="display: none;">
                                <input type="text" class="form-control" id="kategori_pelanggan_custom" placeholder="Ketik kategori custom..."
                                       maxlength="255" value="{{ !in_array($pelanggan->kategori_pelanggan, ['retail', 'wholesale', 'corporate', 'distributor']) ? $pelanggan->kategori_pelanggan : '' }}">
                                <small class="text-muted">Isi kategori sesuai kebutuhan Anda</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating_pelanggan" class="form-label">Rating <span class="text-danger">*</span></label>
                                <select class="form-select @error('rating_pelanggan') is-invalid @enderror"
                                        id="rating_pelanggan" name="rating_pelanggan" required>
                                    <option value="">Pilih Rating</option>
                                    <option value="VIP" {{ old('rating_pelanggan', $pelanggan->rating_pelanggan) == 'VIP' ? 'selected' : '' }}>⭐ VIP</option>
                                    <option value="High" {{ old('rating_pelanggan', $pelanggan->rating_pelanggan) == 'High' ? 'selected' : '' }}>High Priority</option>
                                    <option value="Medium" {{ old('rating_pelanggan', $pelanggan->rating_pelanggan) == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                                    <option value="Low" {{ old('rating_pelanggan', $pelanggan->rating_pelanggan) == 'Low' ? 'selected' : '' }}>Low Priority</option>
                                </select>
                                @error('rating_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_pelanggan" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status_pelanggan') is-invalid @enderror"
                                        id="status_pelanggan" name="status_pelanggan" required>
                                    <option value="aktif" {{ old('status_pelanggan', $pelanggan->status_pelanggan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ old('status_pelanggan', $pelanggan->status_pelanggan) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                    <strong>Kategori:</strong> Pilih dari daftar atau ketik custom di "Lainnya"
                </p>
                <hr>
                <p class="small text-muted mb-0">
                    <strong>Catatan:</strong> Semua perubahan akan disimpan otomatis dengan mencatat waktu update
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleKategoriInput() {
    const kategoriSelect = document.getElementById('kategori_pelanggan');
    const inputGroup = document.getElementById('kategori-input-group');

    if (kategoriSelect.value === 'lainnya') {
        inputGroup.style.display = 'block';
    } else {
        inputGroup.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleKategoriInput();
});

// Form submission - use custom kategori if needed
const formElement = document.querySelector('form');
if (formElement) {
    formElement.addEventListener('submit', function(e) {
        const kategoriSelect = document.getElementById('kategori_pelanggan');
        const kategoriInput = document.getElementById('kategori_pelanggan_custom');

        if (kategoriSelect.value === 'lainnya' && kategoriInput.value) {
            kategoriSelect.value = kategoriInput.value;
        }
    });
}
</script>
@endpush

@endsection
