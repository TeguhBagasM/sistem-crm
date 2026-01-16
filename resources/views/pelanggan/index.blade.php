@extends('layouts.app')

@section('title', 'Contact Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-people"></i> Contact Management</h2>
        <p class="text-muted mb-0">Kelola daftar pelanggan Anda</p>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Pelanggan
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Total Pelanggan</h6>
                        <h4 class="mb-0">{{ $pelanggan->total() }}</h4>
                    </div>
                    <i class="bi bi-people-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Aktif</h6>
                        <h4 class="mb-0">{{ $aktifCount ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Tidak Aktif</h6>
                        <h4 class="mb-0">{{ $tidakAktifCount ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-x-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Dari Lead</h6>
                        <h4 class="mb-0">{{ $konversiCount ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-arrow-left-right" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('pelanggan.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Pelanggan</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Nama atau no. telepon...">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="pemilik" class="form-label">Pemilik Data</label>
                <select class="form-select" id="pemilik" name="pemilik">
                    <option value="">Semua User</option>
                    @foreach($userList ?? [] as $user)
                    <option value="{{ $user->id }}" {{ request('pemilik') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
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

<!-- Pelanggan List -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Perusahaan</th>
                        <th>Status</th>
                        <th>Pemilik Data</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $customer)
                    <tr>
                        <td>{{ $loop->iteration + ($pelanggan->currentPage() - 1) * $pelanggan->perPage() }}</td>
                        <td>
                            <strong>{{ $customer->nama }}</strong>
                            @if($customer->calonPelanggan)
                            <br><small class="text-muted"><i class="bi bi-arrow-return-left"></i> Dari Lead</small>
                            @endif
                        </td>
                        <td>{{ $customer->email ?? '-' }}</td>
                        <td>{{ $customer->no_telepon }}</td>
                        <td>{{ $customer->perusahaan ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $customer->status_pelanggan == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst(str_replace('_', ' ', $customer->status_pelanggan)) }}
                            </span>
                        </td>
                        <td><small>{{ $customer->pemilik->name }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('pelanggan.show', $customer) }}" class="btn btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('pelanggan.edit', $customer) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $customer) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
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
                        <td colspan="8" class="text-center text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Belum ada data pelanggan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pelanggan->links() }}
        </div>
    </div>
</div>
@endsection
