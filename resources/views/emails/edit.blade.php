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
                <form action="{{ route('emails.update', $email) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                        {{ old('id_pelanggan', $email->id_pelanggan) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama }} {{ $customer->email ? '- ' . $customer->email : '(Tidak ada email)' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subjek" class="form-label">
                            Subjek Email <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('subjek') is-invalid @enderror"
                               id="subjek" name="subjek" value="{{ old('subjek', $email->subjek) }}"
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
                                  placeholder="Tulis isi email di sini..." required>{{ old('isi_pesan', $email->isi_pesan) }}</textarea>
                        @error('isi_pesan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Karakter: <span id="char-count">{{ strlen($email->isi_pesan) }}</span></small>
                    </div>

                    <div class="mb-3">
                        <label for="waktu_kirim" class="form-label">
                            Waktu Pencatatan <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control @error('waktu_kirim') is-invalid @enderror"
                               id="waktu_kirim" name="waktu_kirim"
                               value="{{ old('waktu_kirim', $email->waktu_kirim->format('Y-m-d\TH:i')) }}" required>
                        @error('waktu_kirim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Email
                        </button>
                        <button type="button" class="btn btn-success" id="sendEmailBtn">
                            <i class="bi bi-envelope"></i> Kirim Email
                        </button>
                        <a href="{{ route('emails.show', $email) }}" class="btn btn-secondary">
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
                    <strong>Dicatat:</strong> {{ $email->created_at->format('d M Y H:i') }}
                </p>
                <p class="small mb-2">
                    <strong>Terakhir Update:</strong> {{ $email->updated_at->format('d M Y H:i') }}
                </p>
                <p class="small mb-0">
                    <strong>Dikirim Oleh:</strong> {{ $email->pengirim->name }}
                </p>
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

// Send Email Button
const sendEmailBtn = document.getElementById('sendEmailBtn');
const pelangganSelect = document.getElementById('id_pelanggan');
const subjekInput = document.getElementById('subjek');

sendEmailBtn.addEventListener('click', function() {
    const selected = pelangganSelect.options[pelangganSelect.selectedIndex];
    const toEmail = selected.dataset.email;
    const subjek = subjekInput.value;
    const isiPesanValue = isiPesan.value;

    if (!toEmail || toEmail === 'null') {
        alert('Pelanggan tidak memiliki email!');
        return;
    }

    const mailtoLink = `mailto:${toEmail}?subject=${encodeURIComponent(subjek)}&body=${encodeURIComponent(isiPesanValue)}`;
    window.location.href = mailtoLink;
});
</script>
@endpush
@endsection
