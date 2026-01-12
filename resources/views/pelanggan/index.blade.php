@extends('layouts.app')

@section('title', 'Contact Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-people"></i> Contact Management</h2>
        <p class="text-muted mb-0">Kelola data pelanggan Anda</p>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Pelanggan
    </a>
</div>

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
                        <td><strong>{{ $customer->nama }}</strong></td>
                        <td>{{ $customer->email ?? '-' }}</td>
                        <td>{{ $customer->no_telepon }}</td>
                        <td>{{ $customer->perusahaan ?? '-' }}</td>
                        <td><span class="badge {{ $customer->getStatusBadgeClass() }}">{{ $customer->status_pelanggan }}</span></td>
                        <td>{{ $customer->pemilik->name }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('pelanggan.show', $customer) }}" class="btn btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('pelanggan.edit', $customer) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $customer) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
