@extends('layouts.app')

@section('title', 'Catat Email Baru')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-envelope-plus"></i> Catat Email Baru</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('emails.index') }}">Email Management</a></li>
            <li class="breadcrumb-item active">Catat Email Baru</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-envelope"></i> Formulir Email</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('emails.store') }}" method="POST" id="emailForm">
                    @csrf

                    <div class="mb-3">
                        <label for="id_pelanggan" class="form-label">
                            Pelanggan <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('id_pelanggan') is-invalid @enderror"
                                id="id_pelanggan" name="id_pelanggan" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggan as $customer)
                                <option value="{{ $customer->id }}"
                                        data-email="{{ $customer->email }}"
                                        data-nama="{{ $customer->nama }}"
                                        {{ old('id_pelanggan') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama }} {{ $customer->email ? '- ' . $customer->email : '(Tidak ada email)' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted" id="customer-email"></small>
                    </div>

                    <div class="mb-3">
                        <label for="subjek" class="form-label">
                            Subjek Email <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('subjek') is-invalid @enderror"
                               id="subjek" name="subjek" value="{{ old('subjek') }}"
                               placeholder="Contoh: Penawaran Produk Terbaru" required>
                        @error('subjek')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi_pesan" class="form-label">
                            Isi Email <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('isi_pesan') is-invalid @enderror"
                                  id="isi_pesan" name="isi_pesan" rows="10"
                                  placeholder="Tulis isi email di sini..." required>{{ old('isi_pesan') }}</textarea>
                        @error('isi_pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Karakter: <span id="char-count">0</span></small>
                    </div>

                    <div class="mb-3">
                        <label for="waktu_kirim" class="form-label">
                            Waktu Pencatatan <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control @error('waktu_kirim') is-invalid @enderror"
                               id="waktu_kirim" name="waktu_kirim"
                               value="{{ old('waktu_kirim', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('waktu_kirim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Waktu saat email ini akan/sudah dikirim</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Simpan Riwayat
                        </button>
                        <button type="button" class="btn btn-primary" id="sendEmailBtn" disabled>
                            <i class="bi bi-envelope"></i> Kirim Email Sekarang
                        </button>
                        <a href="{{ route('emails.index') }}" class="btn btn-secondary">
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
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Cara Kerja</h6>
                <ol class="small mb-0">
                    <li>Pilih pelanggan tujuan</li>
                    <li>Isi subjek dan pesan email</li>
                    <li>Klik <strong>"Kirim Email Sekarang"</strong> untuk membuka email client</li>
                    <li>Email akan terbuka dengan data terisi otomatis</li>
                    <li>Kirim dari email client Anda</li>
                    <li>Kembali ke form dan klik <strong>"Simpan Riwayat"</strong></li>
                </ol>
            </div>
        </div>

        <div class="card bg-warning">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-lightbulb"></i> Tips</h6>
                <ul class="small mb-0">
                    <li>Tombol "Kirim Email" akan aktif setelah data terisi</li>
                    <li>Email akan terbuka di client default (Gmail, Outlook, dll)</li>
                    <li>Simpan riwayat untuk tracking komunikasi</li>
                </ul>
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

// Show customer email when selected
const pelangganSelect = document.getElementById('id_pelanggan');
const customerEmailDiv = document.getElementById('customer-email');
const sendEmailBtn = document.getElementById('sendEmailBtn');
const subjekInput = document.getElementById('subjek');

pelangganSelect.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const email = selected.dataset.email;

    if (email && email !== 'null') {
        customerEmailDiv.textContent = '📧 ' + email;
        customerEmailDiv.classList.remove('text-danger');
        customerEmailDiv.classList.add('text-success');
        checkSendButtonState();
    } else {
        customerEmailDiv.textContent = '⚠️ Pelanggan ini tidak memiliki email';
        customerEmailDiv.classList.remove('text-success');
        customerEmailDiv.classList.add('text-danger');
        sendEmailBtn.disabled = true;
    }
});

// Check if send email button should be enabled
function checkSendButtonState() {
    const selected = pelangganSelect.options[pelangganSelect.selectedIndex];
    const email = selected.dataset.email;
    const subjek = subjekInput.value.trim();
    const isiPesanValue = isiPesan.value.trim();

    if (email && email !== 'null' && subjek && isiPesanValue) {
        sendEmailBtn.disabled = false;
    } else {
        sendEmailBtn.disabled = true;
    }
}

// Enable/disable send button on input
subjekInput.addEventListener('input', checkSendButtonState);
isiPesan.addEventListener('input', checkSendButtonState);

// Send Email after save
sendEmailBtn.addEventListener('click', function() {
    // First submit the form to save email record
    document.getElementById('emailForm').addEventListener('submit', function(e) {
        // Form will be saved first
    });

    // Submit form
    const form = document.getElementById('emailForm');
    form.submit();

    alert('Email sedang disiapkan untuk dikirim...');
});
</script>
@endpush
@endsection
