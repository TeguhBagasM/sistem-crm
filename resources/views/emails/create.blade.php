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
                <p class="small mb-0">Gunakan form di samping untuk mencatat riwayat email pelanggan Anda. Data tersimpan akan membantu dalam tracking komunikasi dengan pelanggan.</p>
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
</script>
@endpush
@endsection
