@extends('layouts.app')

@section('title', 'Kirim Email Baru')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-envelope-plus"></i> Kirim Email Baru</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('emails.index') }}">Email Management</a></li>
            <li class="breadcrumb-item active">Kirim Email Baru</li>
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
                <form action="{{ route('emails.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_pelanggan" class="form-label">
                            Kepada (Pelanggan) <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('id_pelanggan') is-invalid @enderror"
                                id="id_pelanggan" name="id_pelanggan" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggan as $customer)
                                <option value="{{ $customer->id }}"
                                        data-email="{{ $customer->email }}"
                                        {{ old('id_pelanggan') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama }} - {{ $customer->email ?? 'No Email' }}
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
                        <label for="waktu_kirim" class="form-label">
                            Waktu Kirim <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control @error('waktu_kirim') is-invalid @enderror"
                               id="waktu_kirim" name="waktu_kirim"
                               value="{{ old('waktu_kirim', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('waktu_kirim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Waktu saat email dikirim atau dijadwalkan</small>
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

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Simpan Email
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
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi</h6>
                <p class="small text-muted mb-2">
                    <strong>Email Template:</strong> Gunakan template profesional untuk meningkatkan engagement
                </p>
                <p class="small text-muted mb-0">
                    <strong>Waktu Kirim:</strong> Catat waktu kapan email dikirim untuk tracking komunikasi
                </p>
            </div>
        </div>

        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-lightbulb"></i> Tips Email</h6>
                <ul class="small mb-0">
                    <li>Gunakan subjek yang menarik</li>
                    <li>Personalisasi pesan</li>
                    <li>Sertakan call-to-action</li>
                    <li>Periksa ejaan sebelum kirim</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Character counter
document.getElementById('isi_pesan').addEventListener('input', function() {
    document.getElementById('char-count').textContent = this.value.length;
});

// Show customer email when selected
document.getElementById('id_pelanggan').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const email = selected.dataset.email;
    if (email && email !== 'null') {
        document.getElementById('customer-email').textContent = '📧 ' + email;
    } else {
        document.getElementById('customer-email').textContent = '⚠️ Pelanggan belum memiliki email';
    }
});
</script>
@endpush
@endsection
