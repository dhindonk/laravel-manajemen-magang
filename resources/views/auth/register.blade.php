@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="auth-card">
        <h4 class="auth-title">Register</h4>

        <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" class="form-control @error('no_tlpn') is-invalid @enderror" 
                               name="no_tlpn" value="{{ old('no_tlpn') }}" required>
                        @error('no_tlpn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asal Kampus</label>
                        <input type="text" class="form-control @error('asal_kampus') is-invalid @enderror" 
                               name="asal_kampus" value="{{ old('asal_kampus') }}" required>
                        @error('asal_kampus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Surat dari Kampus (PDF)</label>
                        <input type="file" class="form-control @error('surat_kampus') is-invalid @enderror" 
                               name="surat_kampus" accept=".pdf" required>
                        @error('surat_kampus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Surat dari Bakesbangpol (PDF)</label>
                        <input type="file" class="form-control @error('surat_bakesbangpol') is-invalid @enderror" 
                               name="surat_bakesbangpol" accept=".pdf" required>
                        @error('surat_bakesbangpol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" 
                               name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-auth w-100">Register</button>
            </div>
        </form>

        <div class="auth-link mt-3 text-center">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>

<style>
    .auth-card {
        max-width: 800px;  /* Perlebar card untuk 2 kolom */
        margin: 2rem auto;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    .auth-title {
        text-align: center;
        margin-bottom: 2rem;
        font-weight: 600;
    }

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

    .btn-auth {
        padding: 0.7rem;
        font-weight: 500;
    }

    .auth-link {
        font-size: 0.875rem;
    }

    .auth-link a {
        color: #0d6efd;
        text-decoration: none;
    }

    .auth-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .auth-card {
            margin: 1rem;
            padding: 1.5rem;
        }
    }
</style>
@endsection
