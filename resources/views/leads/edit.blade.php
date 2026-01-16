@extends('layouts.app')

@section('title', 'Edit Lead')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-pencil-square"></i> Edit Lead</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Lead Management</a></li>
            <li class="breadcrumb-item active">Edit Lead</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('leads.update', $lead) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama', $lead->nama) }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $lead->email) }}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                               id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $lead->no_telepon) }}" required>
                        @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sumber" class="form-label">Sumber <span class="text-danger">*</span></label>
                        <select class="form-select @error('sumber') is-invalid @enderror" id="sumber" name="sumber" required>
                            <option value="">Pilih Sumber</option>
                            <option value="IG" {{ old('sumber', $lead->sumber) == 'IG' ? 'selected' : '' }}>Instagram</option>
                            <option value="Website" {{ old('sumber', $lead->sumber) == 'Website' ? 'selected' : '' }}>Website</option>
                            <option value="WA" {{ old('sumber', $lead->sumber) == 'WA' ? 'selected' : '' }}>WhatsApp</option>
                        </select>
                        @error('sumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_lead" class="form-label">Status Lead <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_lead') is-invalid @enderror" id="status_lead" name="status_lead" required>
                            <option value="baru" {{ old('status_lead', $lead->status_lead) == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="dihubungi" {{ old('status_lead', $lead->status_lead) == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
                            <option value="qualified" {{ old('status_lead', $lead->status_lead) == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="gagal" {{ old('status_lead', $lead->status_lead) == 'gagal' ? 'selected' : '' }}>Gagal</option>
                        </select>
                        @error('status_lead')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror"
                                  id="catatan" name="catatan" rows="4">{{ old('catatan', $lead->catatan) }}</textarea>
                        @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">
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
                    <strong>Dibuat:</strong> {{ $lead->created_at->format('d M Y H:i') }}
                </p>
                <p class="small mb-2">
                    <strong>Terakhir Update:</strong> {{ $lead->updated_at->format('d M Y H:i') }}
                </p>
                <p class="small mb-0">
                    <strong>Dibuat Oleh:</strong> {{ $lead->pembuatData->nama }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
