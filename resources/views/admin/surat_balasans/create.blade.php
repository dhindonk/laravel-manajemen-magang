@extends('layouts.app')

@section('title', 'Upload Surat Balasan')

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
                                Upload Surat Balasan
                            </h5>
                            <p class="text-muted mb-0 fs-7">Upload surat balasan untuk mahasiswa</p>
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
                    <!-- Detail Mahasiswa -->
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Detail Mahasiswa</h6>
                        <div class="bg-light p-3 rounded-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted small">Nama Lengkap</p>
                                    <p class="mb-0 fw-medium">{{ $user->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted small">Email</p>
                                    <p class="mb-0">{{ $user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted small">Asal Kampus</p>
                                    <p class="mb-0">{{ $user->asal_kampus }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 text-muted small">Nomor Telepon</p>
                                    <p class="mb-0">{{ $user->no_tlpn }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.surat_balasans.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <div class="mb-4">
                            <label class="form-label">Upload Surat Balasan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-file-upload-line text-muted"></i>
                                </span>
                                <input type="file" 
                                       class="form-control border-start-0 @error('surat') is-invalid @enderror"
                                       name="surat"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       required>
                            </div>
                            <small class="text-muted">Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</small>
                            @error('surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-upload-2-line me-1"></i>
                                Upload Surat
                            </button>
                            <a href="{{ route('admin.verify.users') }}" class="btn btn-light px-4">
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

    .fw-medium {
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .col-md-8 {
            padding: 0 1rem;
        }
    }
</style>

@push('scripts')
<script>
    // Preview file yang diupload
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) { // 2MB
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal adalah 2MB',
                    confirmButtonText: 'OK'
                });
                this.value = '';
            }
        }
    });
</script>
@endpush
@endsection
