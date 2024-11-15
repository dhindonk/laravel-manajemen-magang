@extends('layouts.app')

@section('title', 'Registrasi Akun Magang')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="fw-semibold">Registrasi Akun Magang</h4>
                        <p class="text-muted">Lengkapi data diri Anda</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger py-2">
                            <i class="ri-error-warning-line me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-sm">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-user-line text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control border-start-0 @error('name') is-invalid @enderror"
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-sm">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-mail-line text-muted"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-sm">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-phone-line text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control border-start-0 @error('no_tlpn') is-invalid @enderror"
                                           name="no_tlpn" 
                                           value="{{ old('no_tlpn') }}" 
                                           required>
                                </div>
                                @error('no_tlpn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label text-sm">Asal Kampus</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-building-2-line text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control border-start-0 @error('asal_kampus') is-invalid @enderror"
                                           name="asal_kampus" 
                                           value="{{ old('asal_kampus') }}" 
                                           required>
                                </div>
                                @error('asal_kampus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-sm">Surat dari Kampus (PDF)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-file-text-line text-muted"></i>
                                    </span>
                                    <input type="file" 
                                           class="form-control border-start-0 @error('surat_kampus') is-invalid @enderror"
                                           name="surat_kampus" 
                                           accept=".pdf" 
                                           required>
                                </div>
                                @error('surat_kampus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-sm">Surat Bakesbangpol (PDF)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-file-text-line text-muted"></i>
                                    </span>
                                    <input type="file" 
                                           class="form-control border-start-0 @error('surat_bakesbangpol') is-invalid @enderror"
                                           name="surat_bakesbangpol" 
                                           accept=".pdf" 
                                           required>
                                </div>
                                @error('surat_bakesbangpol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-sm">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-lock-line text-muted"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control border-start-0 @error('password') is-invalid @enderror"
                                           name="password" 
                                           required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-sm">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-lock-line text-muted"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control border-start-0"
                                           name="password_confirmation" 
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="ri-user-add-line me-2"></i>Daftar
                            </button>

                            <p class="text-center text-muted mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    Login di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
