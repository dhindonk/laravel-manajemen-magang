@extends('layouts.app')

@section('title', 'Upload Laporan')

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
                                <i class="ri-file-upload-line me-2 text-primary"></i>
                                Upload Laporan
                            </h5>
                            <p class="text-muted mb-0 fs-7">Upload laporan kegiatan magang Anda</p>
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
                    <form action="{{ route('laporans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">File Laporan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-file-text-line text-muted"></i>
                                </span>
                                <input type="file" 
                                       class="form-control border-start-0 @error('file_laporan') is-invalid @enderror"
                                       name="file_laporan"
                                       accept=".pdf,.doc,.docx">
                            </div>
                            <small class="text-muted">Format: PDF, DOC, DOCX (Maks. 2MB)</small>
                            @error('file_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Keterangan (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-file-list-line text-muted"></i>
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
                                <i class="ri-upload-2-line me-1"></i>
                                Upload Laporan
                            </button>
                            <a href="{{ route('laporans.index') }}" class="btn btn-light px-4">
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

    .form-control {
        font-size: 0.875rem;
    }

    .form-control:focus {
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
