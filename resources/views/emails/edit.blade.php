@extends('layouts.app')

@section('title', 'Edit Email')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-pencil-square"></i> Edit Email</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('emails.index') }}">Email Management</a></li>
            <li class="breadcrumb-item active">Edit Email</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-envelope"></i> Edit Formulir Email</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('emails.update', $email) }}" method="POST" id="emailForm">
                    @csrf
                    @method('PUT')

                    <!-- Tabs untuk Pelanggan dan Leads -->
                    <ul class="nav nav-tabs mb-3" id="recipientTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pelanggan-tab" data-bs-toggle="tab" data-bs-target="#pelanggan-panel" type="button" role="tab">
                                <i class="bi bi-person-check"></i> Pelanggan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="leads-tab" data-bs-toggle="tab" data-bs-target="#leads-panel" type="button" role="tab">
                                <i class="bi bi-person-plus"></i> Leads
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mb-3" id="recipientTabContent">
                        <!-- Pelanggan Tab -->
                        <div class="tab-pane fade show active" id="pelanggan-panel" role="tabpanel">
                            <div class="mb-3">
                                <label for="pelanggan-search" class="form-label">
                                    <i class="bi bi-search"></i> Cari Pelanggan
                                </label>
                                <input type="text" class="form-control" id="pelanggan-search" placeholder="Ketik nama atau email pelanggan...">
                            </div>

                            <div id="pelanggan-search-results" class="mb-3">
                                <div id="pelanggan-results-list" class="list-group"></div>
                                <p id="pelanggan-no-results" class="text-muted text-center py-3">Ketik nama atau email untuk mencari pelanggan</p>
                            </div>

                            <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="{{ old('id_pelanggan', $email->id_pelanggan) }}">
                            <div id="selected-pelanggan" class="alert alert-info mt-3 {{ $email->id_pelanggan ? '' : 'd-none' }}">
                                <i class="bi bi-check-circle"></i> Pelanggan Dipilih: <strong id="selected-pelanggan-name">{{ $email->pelanggan?->nama }}</strong><br>
                                <small id="selected-pelanggan-email">{{ $email->pelanggan?->email }}</small>
                            </div>
                        </div>

                        <!-- Leads Tab -->
                        <div class="tab-pane fade" id="leads-panel" role="tabpanel">
                            <div class="mb-3">
                                <label for="leads-search" class="form-label">
                                    <i class="bi bi-search"></i> Cari Leads
                                </label>
                                <input type="text" class="form-control" id="leads-search" placeholder="Ketik nama atau email leads...">
                            </div>

                            <div id="leads-search-results" class="mb-3">
                                <div id="leads-results-list" class="list-group"></div>
                                <p id="leads-no-results" class="text-muted text-center py-3">Ketik nama atau email untuk mencari leads</p>
                            </div>

                            <input type="hidden" id="id_calon_pelanggan" name="id_calon_pelanggan" value="{{ old('id_calon_pelanggan', $email->id_calon_pelanggan) }}">
                            <div id="selected-leads" class="alert alert-info mt-3 {{ $email->id_calon_pelanggan ? '' : 'd-none' }}">
                                <i class="bi bi-check-circle"></i> Leads Dipilih: <strong id="selected-leads-name">{{ $email->calonPelanggan?->nama }}</strong><br>
                                <small id="selected-leads-email">{{ $email->calonPelanggan?->email }}</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Subjek Email -->
                    <div class="mb-3">
                        <label for="subjek" class="form-label">
                            <i class="bi bi-tag"></i> Subjek Email <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('subjek') is-invalid @enderror"
                               id="subjek" name="subjek" value="{{ old('subjek', $email->subjek) }}"
                               placeholder="Contoh: Penawaran Produk Terbaru" required>
                        @error('subjek')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Isi Pesan -->
                    <div class="mb-3">
                        <label for="isi_pesan" class="form-label">
                            <i class="bi bi-pencil"></i> Isi Pesan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('isi_pesan') is-invalid @enderror"
                                  id="isi_pesan" name="isi_pesan" rows="10"
                                  placeholder="Tulis isi email di sini..." required>{{ old('isi_pesan', $email->isi_pesan) }}</textarea>
                        @error('isi_pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Karakter: <span id="char-count">{{ strlen($email->isi_pesan) }}</span></small>
                    </div>

                    <!-- Waktu Kirim -->
                    <div class="mb-3">
                        <label for="waktu_kirim" class="form-label">
                            <i class="bi bi-calendar-event"></i> Waktu Kirim <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control @error('waktu_kirim') is-invalid @enderror"
                               id="waktu_kirim" name="waktu_kirim"
                               value="{{ old('waktu_kirim', $email->waktu_kirim->format('Y-m-d\TH:i')) }}" required>
                        @error('waktu_kirim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Aksi -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-gear"></i> Aksi <span class="text-danger">*</span>
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" id="action-save"
                                   value="save_only" {{ old('action', 'save_only') == 'save_only' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="action-save">
                                <i class="bi bi-save"></i> <strong>Simpan Saja</strong>
                                <small class="d-block text-muted">Hanya update data email</small>
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="action" id="action-send"
                                   value="send_email" {{ old('action') == 'send_email' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="action-send">
                                <i class="bi bi-send"></i> <strong>Kirim Sekarang</strong>
                                <small class="d-block text-muted">Update dan langsung kirim email ke penerima</small>
                            </label>
                        </div>
                    </div>

                    <!-- Info Alert -->
                    <div id="email-info-alert" class="alert alert-info d-none" role="alert">
                        <i class="bi bi-info-circle"></i> Email Penerima: <strong id="customer-email-display"></strong>
                    </div>

                    <!-- Form Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Proses
                        </button>
                        <a href="{{ route('emails.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi</h6>
                <table class="table table-sm">
                    <tr>
                        <td><strong>Dicatat:</strong></td>
                        <td>{{ $email->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Update Terakhir:</strong></td>
                        <td>{{ $email->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dikirim Oleh:</strong></td>
                        <td>{{ $email->pengirim->name }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Character counter
const isiPesan = document.getElementById('isi_pesan');
const charCount = document.getElementById('char-count');

isiPesan.addEventListener('input', function() {
    charCount.textContent = this.value.length;
});

// Tab switching - clear selections when switching
document.getElementById('pelanggan-tab').addEventListener('click', function() {
    clearLeadsSelection();
});

document.getElementById('leads-tab').addEventListener('click', function() {
    clearPelangganSelection();
});

// Pelanggan Search
const pelangganSearch = document.getElementById('pelanggan-search');
const pelangganResultsList = document.getElementById('pelanggan-results-list');
const pelangganNoResults = document.getElementById('pelanggan-no-results');
const allPelanggan = @json($pelanggan);

pelangganSearch.addEventListener('input', function() {
    const query = this.value.toLowerCase();

    if (query.length === 0) {
        pelangganResultsList.innerHTML = '';
        pelangganNoResults.style.display = 'block';
        return;
    }

    const filtered = allPelanggan.filter(p =>
        p.nama.toLowerCase().includes(query) ||
        (p.email && p.email.toLowerCase().includes(query))
    );

    if (filtered.length === 0) {
        pelangganResultsList.innerHTML = '';
        pelangganNoResults.textContent = 'Tidak ada pelanggan yang cocok';
        pelangganNoResults.style.display = 'block';
        return;
    }

    pelangganNoResults.style.display = 'none';
    pelangganResultsList.innerHTML = filtered.map(p => `
        <button type="button" class="list-group-item list-group-item-action pelanggan-item"
                data-id="${p.id}" data-email="${p.email || ''}" data-nama="${p.nama}">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1">${p.nama}</h6>
                    <small class="text-muted">${p.email || 'Tidak ada email'}</small>
                </div>
                <div class="text-end text-muted">
                    <small>${p.no_telepon}</small>
                </div>
            </div>
        </button>
    `).join('');

    // Attach click handlers
    document.querySelectorAll('#pelanggan-results-list .pelanggan-item').forEach(item => {
        item.addEventListener('click', selectPelanggan);
    });
});

// Leads Search
const leadsSearch = document.getElementById('leads-search');
const leadsResultsList = document.getElementById('leads-results-list');
const leadsNoResults = document.getElementById('leads-no-results');
const allLeads = @json($leads);

leadsSearch.addEventListener('input', function() {
    const query = this.value.toLowerCase();

    if (query.length === 0) {
        leadsResultsList.innerHTML = '';
        leadsNoResults.style.display = 'block';
        return;
    }

    const filtered = allLeads.filter(l =>
        l.nama.toLowerCase().includes(query) ||
        (l.email && l.email.toLowerCase().includes(query))
    );

    if (filtered.length === 0) {
        leadsResultsList.innerHTML = '';
        leadsNoResults.textContent = 'Tidak ada leads yang cocok';
        leadsNoResults.style.display = 'block';
        return;
    }

    leadsNoResults.style.display = 'none';
    leadsResultsList.innerHTML = filtered.map(l => `
        <button type="button" class="list-group-item list-group-item-action leads-item"
                data-id="${l.id}" data-email="${l.email || ''}" data-nama="${l.nama}">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1">${l.nama}</h6>
                    <small class="text-muted">${l.email || 'Tidak ada email'}</small>
                </div>
                <div class="text-end text-muted">
                    <small>${l.no_telepon}</small>
                </div>
            </div>
        </button>
    `).join('');

    // Attach click handlers
    document.querySelectorAll('#leads-results-list .leads-item').forEach(item => {
        item.addEventListener('click', selectLeads);
    });
});

// Select Pelanggan
function selectPelanggan(e) {
    e.preventDefault();
    const id = this.getAttribute('data-id');
    const email = this.getAttribute('data-email');
    const nama = this.getAttribute('data-nama');

    document.getElementById('id_pelanggan').value = id;
    document.getElementById('selected-pelanggan-name').textContent = nama;
    document.getElementById('selected-pelanggan-email').textContent = email;
    document.getElementById('selected-pelanggan').classList.remove('d-none');
    document.getElementById('customer-email-display').textContent = email;
    document.getElementById('email-info-alert').classList.remove('d-none');

    // Highlight selected
    document.querySelectorAll('.pelanggan-item').forEach(item => {
        item.classList.remove('active');
        item.style.backgroundColor = '';
    });
    this.classList.add('active');
    this.style.backgroundColor = '#e7f3ff';

    // Clear leads selection
    clearLeadsSelection();
}

// Select Leads
function selectLeads(e) {
    e.preventDefault();
    const id = this.getAttribute('data-id');
    const email = this.getAttribute('data-email');
    const nama = this.getAttribute('data-nama');

    document.getElementById('id_calon_pelanggan').value = id;
    document.getElementById('selected-leads-name').textContent = nama;
    document.getElementById('selected-leads-email').textContent = email;
    document.getElementById('selected-leads').classList.remove('d-none');
    document.getElementById('customer-email-display').textContent = email;
    document.getElementById('email-info-alert').classList.remove('d-none');

    // Highlight selected
    document.querySelectorAll('.leads-item').forEach(item => {
        item.classList.remove('active');
        item.style.backgroundColor = '';
    });
    this.classList.add('active');
    this.style.backgroundColor = '#e7f3ff';

    // Clear pelanggan selection
    clearPelangganSelection();
}

// Clear selections
function clearPelangganSelection() {
    document.getElementById('id_pelanggan').value = '';
    document.getElementById('selected-pelanggan').classList.add('d-none');
    document.querySelectorAll('.pelanggan-item').forEach(item => {
        item.classList.remove('active');
        item.style.backgroundColor = '';
    });
}

function clearLeadsSelection() {
    document.getElementById('id_calon_pelanggan').value = '';
    document.getElementById('selected-leads').classList.add('d-none');
    document.querySelectorAll('.leads-item').forEach(item => {
        item.classList.remove('active');
        item.style.backgroundColor = '';
    });
}

// Initialize event listeners on page load
document.addEventListener('DOMContentLoaded', function() {
    // Attach click handlers for initial items
    document.querySelectorAll('.pelanggan-item').forEach(item => {
        item.addEventListener('click', selectPelanggan);
    });

    document.querySelectorAll('.leads-item').forEach(item => {
        item.addEventListener('click', selectLeads);
    });
});

// Form submission - validate at least one recipient
document.getElementById('emailForm').addEventListener('submit', function(e) {
    const pelangganId = document.getElementById('id_pelanggan').value;
    const leadsId = document.getElementById('id_calon_pelanggan').value;

    if (!pelangganId && !leadsId) {
        e.preventDefault();
        alert('Silakan pilih pelanggan atau leads!');
        return false;
    }
});
</script>
@endpush

@endsection
