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

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary" data-stat="total">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Total Lead</h6>
                        <h4 class="mb-0">{{ $leads->total() }}</h4>
                    </div>
                    <i class="bi bi-person-plus-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info" data-stat="qualified">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Qualified</h6>
                        <h4 class="mb-0">{{ $qualifiedCount ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning" data-stat="dihubungi">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Dihubungi</h6>
                        <h4 class="mb-0">{{ $dihubungiCount ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-telephone-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger" data-stat="gagal">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2">Gagal</h6>
                        <h4 class="mb-0">{{ $gagalCount ?? 0 }}</h4>
                    </div>
                    <i class="bi bi-x-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('leads.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Lead</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Nama atau no. telepon...">
            </div>
            <div class="col-md-3">
                <label for="sumber" class="form-label">Sumber</label>
                <select class="form-select" id="sumber" name="sumber">
                    <option value="">Semua Sumber</option>
                    <option value="IG" {{ request('sumber') == 'IG' ? 'selected' : '' }}>Instagram</option>
                    <option value="Website" {{ request('sumber') == 'Website' ? 'selected' : '' }}>Website</option>
                    <option value="WA" {{ request('sumber') == 'WA' ? 'selected' : '' }}>WhatsApp</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="dihubungi" {{ request('status') == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
                    <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                    <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
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

<!-- Lead List -->
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
                        <th>Alamat</th>
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
                        <td>{{ Str::limit($lead->alamat, 30) ?? '-' }}</td>
                        <td><span class="badge bg-secondary">{{ $lead->sumber }}</span></td>
                        <td>
                            @if($lead->pelanggan)
                                <span class="badge bg-success">
                                    <i class="bi bi-lock-fill"></i> {{ ucfirst($lead->status_lead) }}
                                </span>
                                <small class="d-block text-success mt-1">✓ Sudah di Contact</small>
                            @else
                                <select class="form-select form-select-sm status-select" data-lead-id="{{ $lead->id }}" onchange="updateLeadStatus(this)">
                                    <option value="baru" {{ $lead->status_lead == 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="dihubungi" {{ $lead->status_lead == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
                                    <option value="qualified" {{ $lead->status_lead == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                    <option value="gagal" {{ $lead->status_lead == 'gagal' ? 'selected' : '' }}>Gagal</option>
                                </select>
                            @endif
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
                        <td colspan="9" class="text-center text-muted">
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
function updateLeadStatus(selectElement) {
    // Get leadId from data attribute
    const leadId = selectElement.dataset.leadId;
    const newStatus = selectElement.value;
    const previousStatus = selectElement.dataset.previousValue;

    // Validasi leadId
    if (!leadId) {
        console.error('Lead ID tidak ditemukan!');
        alert('❌ Error: Lead ID tidak ditemukan');
        return;
    }

    // Show loading state
    selectElement.disabled = true;

    console.log(`Mengubah status lead ${leadId} menjadi ${newStatus}`);

    // Submit via AJAX dengan PATCH method
    fetch(`/leads/${leadId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            status_lead: newStatus
        })
    })
    .then(response => {
        console.log('Response Status:', response.status);

        if (response.status === 200) {
            return response.json().then(data => {
                selectElement.dataset.previousValue = newStatus;
                console.log('✓ Status berhasil diubah menjadi: ' + newStatus);

                // Update statistics cards realtime
                if (data.stats) {
                    updateStatisticsCards(data.stats);
                }

                selectElement.disabled = false;
                return;
            });
        } else if (response.status === 403) {
            return response.json().then(data => {
                console.warn('Lead Locked:', data.message);
                alert(data.message);
                selectElement.value = previousStatus || '';
                selectElement.disabled = false;
            });
        } else if (response.status === 422) {
            return response.json().then(data => {
                console.error('Validation Error:', data);
                const errorMsg = data.errors?.status_lead?.[0] || 'Validasi gagal';
                alert('❌ ' + errorMsg);
                selectElement.value = previousStatus || '';
                selectElement.disabled = false;
            });
        } else {
            return response.json().then(data => {
                console.error('Server Error:', data);
                alert('❌ Error ' + response.status + ': ' + (data.message || 'Gagal mengubah status'));
                selectElement.value = previousStatus || '';
                selectElement.disabled = false;
            }).catch(err => {
                console.error('Error parsing response:', err);
                alert('❌ Terjadi kesalahan. Silakan coba lagi.');
                selectElement.value = previousStatus || '';
                selectElement.disabled = false;
            });
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        alert('❌ Error: ' + error.message);
        selectElement.value = previousStatus || '';
        selectElement.disabled = false;
    });
}

// Update statistics cards realtime
function updateStatisticsCards(stats) {
    // Update qualified card
    const qualifiedCard = document.querySelector('.card[data-stat="qualified"]');
    if (qualifiedCard) {
        const qualifiedValue = qualifiedCard.querySelector('h4');
        if (qualifiedValue) {
            qualifiedValue.textContent = stats.qualified;
        }
    }

    // Update dihubungi card
    const dihubungiCard = document.querySelector('.card[data-stat="dihubungi"]');
    if (dihubungiCard) {
        const dihubungiValue = dihubungiCard.querySelector('h4');
        if (dihubungiValue) {
            dihubungiValue.textContent = stats.dihubungi;
        }
    }

    // Update gagal card
    const gagalCard = document.querySelector('.card[data-stat="gagal"]');
    if (gagalCard) {
        const gagalValue = gagalCard.querySelector('h4');
        if (gagalValue) {
            gagalValue.textContent = stats.gagal;
        }
    }
}

// Store initial status values
document.querySelectorAll('.status-select').forEach(select => {
    select.dataset.previousValue = select.value;
});
</script>
@endpush
