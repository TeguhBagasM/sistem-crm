@extends('layouts.app')

@section('title', 'Lead Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-person-plus"></i> Lead Management</h2>
        <p class="text-muted mb-0">Kelola calon pelanggan Anda</p>
    </div>
    <a href="{{ route('leads.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Lead
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
                        <th>Sumber</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td>{{ $loop->iteration + ($leads->currentPage() - 1) * $leads->perPage() }}</td>
                        <td><strong>{{ $lead->nama }}</strong></td>
                        <td>{{ $lead->email ?? '-' }}</td>
                        <td>{{ $lead->no_telepon }}</td>
                        <td><span class="badge bg-secondary">{{ $lead->sumber }}</span></td>
                        <td>
                            <form action="{{ route('leads.update-status', $lead) }}" method="POST" class="d-inline status-form">
                                @csrf
                                @method('PATCH')
                                <select class="form-select form-select-sm status-select" name="status_lead" data-lead-id="{{ $lead->id }}">
                                    <option value="baru" {{ $lead->status_lead == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="dihubungi" {{ $lead->status_lead == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
                                    <option value="qualified" {{ $lead->status_lead == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                    <option value="gagal" {{ $lead->status_lead == 'gagal' ? 'selected' : '' }}>Gagal</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ $lead->pembuatData->name }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('leads.show', $lead) }}" class="btn btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline"
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
                            <p class="mt-2">Belum ada data lead</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-submit form when status select changes
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const form = this.closest('.status-form');
        
        // Show loading state
        const originalText = this.innerHTML;
        this.disabled = true;
        this.style.opacity = '0.5';
        
        // Submit form via AJAX
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                // Show success message
                const badge = this.closest('td');
                const statusValue = this.value;
                const statusText = this.options[this.selectedIndex].text;
                
                // Optional: Show toast/alert
                console.log('Status berhasil diubah ke: ' + statusText);
            } else {
                throw new Error('Gagal mengubah status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengubah status. Silakan coba lagi.');
            // Revert to previous selection
            this.value = this.dataset.previousValue || '';
        })
        .finally(() => {
            // Remove loading state
            this.disabled = false;
            this.style.opacity = '1';
        });
    });
    
    // Store initial value
    select.dataset.previousValue = select.value;
});
</script>
@endpush
