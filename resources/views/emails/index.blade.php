@extends('layouts.app')

@section('title', 'Email Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-envelope"></i> Email Management</h2>
        <p class="text-muted mb-0">Kelola riwayat komunikasi email dengan pelanggan</p>
    </div>
    <a href="{{ route('emails.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Kirim Email Baru
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Email</h6>
                        <h2 class="mb-0">{{ $emails->total() }}</h2>
                    </div>
                    <i class="bi bi-envelope-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Email Bulan Ini</h6>
                        <h2 class="mb-0">{{ $emailBulanIni }}</h2>
                    </div>
                    <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Email Minggu Ini</h6>
                        <h2 class="mb-0">{{ $emailMingguIni }}</h2>
                    </div>
                    <i class="bi bi-calendar-week" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Email Hari Ini</h6>
                        <h2 class="mb-0">{{ $emailHariIni }}</h2>
                    </div>
                    <i class="bi bi-send-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('emails.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Email</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Subjek atau isi email...">
            </div>
            <div class="col-md-3">
                <label for="pelanggan_id" class="form-label">Pelanggan</label>
                <select class="form-select" id="pelanggan_id" name="pelanggan_id">
                    <option value="">Semua Pelanggan</option>
                    @foreach($pelangganList as $customer)
                        <option value="{{ $customer->id }}" {{ request('pelanggan_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal"
                       value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Email List -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Pelanggan</th>
                        <th width="25%">Subjek</th>
                        <th width="15%">Waktu Kirim</th>
                        <th width="15%">Dikirim Oleh</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emails as $email)
                    <tr>
                        <td>{{ $loop->iteration + ($emails->currentPage() - 1) * $emails->perPage() }}</td>
                        <td>
                            <strong>{{ $email->pelanggan->nama }}</strong><br>
                            <small class="text-muted">{{ $email->pelanggan->email }}</small>
                        </td>
                        <td>
                            <strong>{{ $email->subjek }}</strong><br>
                            <small class="text-muted">{{ Str::limit($email->isi_pesan, 50) }}</small>
                        </td>
                        <td>
                            <i class="bi bi-calendar"></i> {{ $email->waktu_kirim->format('d M Y') }}<br>
                            <small class="text-muted"><i class="bi bi-clock"></i> {{ $email->waktu_kirim->format('H:i') }}</small>
                        </td>
                        <td>{{ $email->pengirim->name }}</td>
                        <td>
                            @php
                                $statusClass = match($email->status_kirim) {
                                    'sent' => 'bg-success',
                                    'draft' => 'bg-warning',
                                    'failed' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                $statusLabel = match($email->status_kirim) {
                                    'sent' => 'Terkirim',
                                    'draft' => 'Draft',
                                    'failed' => 'Gagal',
                                    default => 'Unknown'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('emails.show', $email) }}" class="btn btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('emails.edit', $email) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('emails.destroy', $email) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus riwayat email ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Belum ada riwayat email</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $emails->links() }}
        </div>
    </div>
</div>
@endsection

