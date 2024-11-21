@extends('layouts.app')

@section('title', 'Edit Admin Divisi')

@section('content')
<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-semibold">
                                <i class="ri-user-settings-line me-2 text-primary"></i>
                                Edit Admin Divisi
                            </h5>
                            <p class="text-muted mb-0 fs-7">Edit data admin divisi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('super_admin.admin-divisi.update', $adminDivisi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-line text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('name') is-invalid @enderror"
                                       name="name"
                                       value="{{ old('name', $adminDivisi->name) }}"
                                       required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-mail-line text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email', $adminDivisi->email) }}"
                                       required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Divisi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-building-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0 @error('divisi_id') is-invalid @enderror"
                                        name="divisi_id"
                                        required>
                                    <option value="">Pilih Divisi</option>
                                    @foreach($divisis as $divisi)
                                        <option value="{{ $divisi->id }}" 
                                                {{ old('divisi_id', $adminDivisi->divisi_id) == $divisi->id ? 'selected' : '' }}>
                                            {{ $divisi->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('divisi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-lock-line text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                                       name="password">
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-lock-line text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-start-0"
                                       name="password_confirmation">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-save-line me-1"></i>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('super_admin.admin-divisi.index') }}" class="btn btn-light px-4">
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
@endsection 