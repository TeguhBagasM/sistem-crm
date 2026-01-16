@extends('layouts.app')

@section('title', 'Detail Email')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-envelope-open"></i> Detail Email</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('emails.index') }}">Email Management</a></li>
            <li class="breadcrumb-item active">Detail Email</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-envelope"></i> {{ $email->subjek }}</h5>
                    <div>
                        @if($email->pelanggan->email)
                        <form action="{{ route('emails.send', $email) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Kirim email ke ' + '{{ $email->pelanggan->email }}' + '?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-send"></i> Kirim Email
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('emails.edit', $email) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('emails.destroy', $email) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus email ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="email-header mb-4 p-3 bg-light rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-person-circle"></i> Dari:</strong><br>
                                <span class="text-primary">{{ $email->pengirim->name }}</span><br>
                                <small class="text-muted">{{ $email->pengirim->email }}</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-person-check"></i> Kepada:</strong><br>
                                <span class="text-primary">{{ $email->pelanggan->nama }}</span><br>
                                <small class="text-muted">{{ $email->pelanggan->email ?? 'Tidak ada email' }}</small>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">
                                <strong><i class="bi bi-calendar-event"></i> Tanggal:</strong><br>
                                {{ $email->waktu_kirim->format('d F Y') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">
                                <strong><i class="bi bi-clock"></i> Waktu:</strong><br>
                                {{ $email->waktu_kirim->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>

                <div class="email-content">
                    <h6 class="mb-3"><i class="bi bi-file-text"></i> Isi Pesan:</h6>
                    <div class="p-4 bg-light rounded" style="min-height: 300px; white-space: pre-wrap;">{{ $email->isi_pesan }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Informasi Email</h6>
                <table class="table table-sm">
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="badge {{ $email->waktu_kirim->isToday() ? 'bg-success' : 'bg-secondary' }}">
                                {{ $email->waktu_kirim->isToday() ? 'Baru Tercatat' : 'Tercatat' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dicatat</strong></td>
                        <td>{{ $email->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate</strong></td>
                        <td>{{ $email->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Panjang Teks</strong></td>
                        <td>{{ strlen($email->isi_pesan) }} karakter</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-person"></i> Info Pelanggan</h6>
                <p class="mb-1"><strong>{{ $email->pelanggan->nama }}</strong></p>
                <p class="mb-1 small">📧 {{ $email->pelanggan->email ?? 'Tidak ada email' }}</p>
                <p class="mb-1 small">📱 {{ $email->pelanggan->no_telepon }}</p>
                @if($email->pelanggan->perusahaan)
                <p class="mb-0 small">🏢 {{ $email->pelanggan->perusahaan }}</p>
                @endif
                <hr class="bg-white">
                <a href="{{ route('pelanggan.show', $email->pelanggan) }}" class="btn btn-sm btn-light w-100">
                    <i class="bi bi-eye"></i> Lihat Detail Pelanggan
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
