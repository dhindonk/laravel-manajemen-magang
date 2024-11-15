@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-semibold">
                                <i class="ri-calendar-check-line me-2 text-primary"></i>
                                Tambah Absensi
                            </h5>
                            <p class="text-muted mb-0 fs-7">Isi form absensi harian Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('absens.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-calendar-line text-muted"></i>
                                </span>
                                <input type="date" 
                                       class="form-control border-start-0 @error('tanggal') is-invalid @enderror"
                                       name="tanggal" 
                                       value="{{ old('tanggal', date('Y-m-d')) }}">
                            </div>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Kehadiran</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-follow-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0 @error('status') is-invalid @enderror" 
                                        name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Foto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-image-line text-muted"></i>
                                </span>
                                <input type="file" 
                                       class="form-control border-start-0 @error('bukti_foto') is-invalid @enderror"
                                       name="bukti_foto"
                                       accept="image/*">
                            </div>
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                            @error('bukti_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Keterangan (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-file-text-line text-muted"></i>
                                </span>
                                <textarea class="form-control border-start-0 @error('keterangan') is-invalid @enderror"
                                          name="keterangan" 
                                          rows="3"
                                          placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan') }}</textarea>
                            </div>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-save-line me-1"></i>
                                Simpan Absensi
                            </button>
                            <a href="{{ route('absens.index') }}" class="btn btn-light px-4">
                                <i class="ri-arrow-left-line me-1"></i>
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 500;
        font-size: 0.875rem;
        color: #4a5568;
    }

    .form-control, .form-select {
        font-size: 0.875rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .15);
    }

    .input-group-text {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .btn {
        font-weight: 500;
        padding: 0.5rem 1rem;
    }

    .text-muted {
        font-size: 0.75rem;
    }

    .invalid-feedback {
        font-size: 0.75rem;
    }

    @media (max-width: 768px) {
        .col-md-8 {
            padding: 0 1rem;
        }
    }
</style>
@endsection 