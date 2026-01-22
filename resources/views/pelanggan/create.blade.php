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
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Form Tambah Pelanggan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelanggan.store') }}" method="POST" id="formPelanggan">
                    @csrf

                    <!-- Konversi dari Lead Section -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <h6 class="mb-3"><i class="bi bi-arrow-left-right"></i> Konversi dari Lead (Opsional)</h6>

                        <div class="mb-3">
                            <label for="leads-search" class="form-label">Cari Lead</label>
                            <input type="text" class="form-control" id="leads-search" placeholder="Ketik nama atau email lead untuk mencari...">
                            <small class="text-muted">Pilih lead untuk otomatis mengisi data</small>
                        </div>

                        <div id="leads-results" class="mb-3">
                            <div id="leads-list" class="list-group" style="max-height: 300px; overflow-y: auto;"></div>
                            <p id="leads-empty" class="text-muted text-center py-3">Ketik untuk mencari lead</p>
                        </div>

                        <input type="hidden" id="id_calon_pelanggan" name="id_calon_pelanggan">
                        <div id="selected-lead-alert" class="alert alert-info d-none mb-0">
                            <i class="bi bi-check-circle"></i> Lead Dipilih: <strong id="selected-lead-name"></strong>
                            <small class="d-block">Email: <span id="selected-lead-email"></span></small>
                        </div>
                    </div>

                    <hr>

                    <!-- Data Pelanggan Section -->
                    <h6 class="mb-3"><i class="bi bi-info-circle"></i> Data Pelanggan</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                       id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}">
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
                                       id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                                @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="perusahaan" class="form-label">Perusahaan</label>
                                <input type="text" class="form-control @error('perusahaan') is-invalid @enderror"
                                       id="perusahaan" name="perusahaan" value="{{ old('perusahaan') }}">
                                @error('perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control @error('website') is-invalid @enderror"
                               id="website" name="website" value="{{ old('website') }}" placeholder="https://...">
                        @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                  id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan_internal" class="form-label"><i class="bi bi-chat-left-text"></i> Catatan Internal</label>
                        <textarea class="form-control @error('catatan_internal') is-invalid @enderror"
                                  id="catatan_internal" name="catatan_internal" rows="2" placeholder="Catatan khusus untuk tim...">{{ old('catatan_internal') }}</textarea>
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
                                <label for="kategori_pelanggan" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori_pelanggan') is-invalid @enderror"
                                        id="kategori_pelanggan" name="kategori_pelanggan" onchange="toggleKategoriInput()">
                                    <option value="">Pilih Kategori</option>
                                    <option value="retail" {{ old('kategori_pelanggan') == 'retail' ? 'selected' : '' }}>Retail</option>
                                    <option value="wholesale" {{ old('kategori_pelanggan') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                    <option value="corporate" {{ old('kategori_pelanggan') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                    <option value="distributor" {{ old('kategori_pelanggan') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                    <option value="lainnya" {{ old('kategori_pelanggan') == 'lainnya' ? 'selected' : '' }}>Lainnya (Ketik Manual)</option>
                                </select>
                                @error('kategori_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="kategori-input-group" class="mb-3" style="display: none;">
                                <input type="text" class="form-control" id="kategori_pelanggan_custom" placeholder="Ketik kategori custom..."
                                       maxlength="255">
                                <small class="text-muted">Isi kategori sesuai kebutuhan Anda</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating_pelanggan" class="form-label">Rating <span class="text-danger">*</span></label>
                                <select class="form-select @error('rating_pelanggan') is-invalid @enderror"
                                        id="rating_pelanggan" name="rating_pelanggan" required>
                                    <option value="">Pilih Rating</option>
                                    <option value="VIP" {{ old('rating_pelanggan') == 'VIP' ? 'selected' : '' }}>⭐ VIP</option>
                                    <option value="High" {{ old('rating_pelanggan') == 'High' ? 'selected' : '' }}>High Priority</option>
                                    <option value="Medium" {{ old('rating_pelanggan', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium Priority</option>
                                    <option value="Low" {{ old('rating_pelanggan') == 'Low' ? 'selected' : '' }}>Low Priority</option>
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
                                    <option value="aktif" {{ old('status_pelanggan', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ old('status_pelanggan') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Pelanggan
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
        <div class="card bg-light mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Info</h6>
                <p class="small text-muted mb-2">
                    <strong>Rating:</strong> Gunakan untuk prioritas follow-up. VIP = follow-up ASAP
                </p>
                <p class="small text-muted mb-2">
                    <strong>Kategori:</strong> Tipe pelanggan untuk analisis dan strategi
                </p>
                <p class="small text-muted mb-0">
                    <strong>Sumber:</strong> Asal pelanggan untuk ROI tracking
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const allLeads = @json($leads);

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
document.getElementById('formPelanggan').addEventListener('submit', function(e) {
    const kategoriSelect = document.getElementById('kategori_pelanggan');
    const kategoriInput = document.getElementById('kategori_pelanggan_custom');

    if (kategoriSelect.value === 'lainnya' && kategoriInput.value) {
        kategoriSelect.value = kategoriInput.value;
    }
});

document.getElementById('leads-search').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const leadsListDiv = document.getElementById('leads-list');
    const leadsEmptyDiv = document.getElementById('leads-empty');

    if (query.length === 0) {
        leadsListDiv.innerHTML = '';
        leadsEmptyDiv.textContent = 'Ketik untuk mencari lead';
        leadsEmptyDiv.style.display = 'block';
        return;
    }

    const filtered = allLeads.filter(l =>
        l.nama.toLowerCase().includes(query) ||
        l.email.toLowerCase().includes(query)
    );

    if (filtered.length === 0) {
        leadsListDiv.innerHTML = '';
        leadsEmptyDiv.textContent = 'Tidak ada lead yang cocok';
        leadsEmptyDiv.style.display = 'block';
        return;
    }

    leadsEmptyDiv.style.display = 'none';
    leadsListDiv.innerHTML = filtered.map(l => `
        <button type="button" class="list-group-item list-group-item-action lead-select" data-id="${l.id}" data-nama="${l.nama}" data-email="${l.email}" data-telepon="${l.no_telepon}" data-alamat="${l.alamat || ''}">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1">${l.nama}</h6>
                    <small class="text-muted">${l.email}</small>
                </div>
                <span class="badge bg-info">Qualified</span>
            </div>
        </button>
    `).join('');

    // Attach handlers
    document.querySelectorAll('.lead-select').forEach(btn => {
        btn.addEventListener('click', selectLead);
    });
});

function selectLead(e) {
    e.preventDefault();
    const id = this.getAttribute('data-id');
    const nama = this.getAttribute('data-nama');
    const email = this.getAttribute('data-email');
    const telepon = this.getAttribute('data-telepon');
    const alamat = this.getAttribute('data-alamat');

    // Populate form
    document.getElementById('id_calon_pelanggan').value = id;
    document.getElementById('nama').value = nama;
    document.getElementById('email').value = email;
    document.getElementById('no_telepon').value = telepon;
    document.getElementById('alamat').value = alamat;

    // Show confirmation
    document.getElementById('selected-lead-name').textContent = nama;
    document.getElementById('selected-lead-email').textContent = email;
    document.getElementById('selected-lead-alert').classList.remove('d-none');

    // Clear search
    document.getElementById('leads-search').value = '';
    document.getElementById('leads-list').innerHTML = '';
    document.getElementById('leads-empty').textContent = 'Ketik untuk mencari lead';
    document.getElementById('leads-empty').style.display = 'block';

    // Scroll to form
    document.getElementById('formPelanggan').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endpush
@endsection
