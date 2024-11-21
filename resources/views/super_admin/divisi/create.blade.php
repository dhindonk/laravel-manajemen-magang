@extends('layouts.app')

@section('title', 'Tambah Divisi')

@section('content')
<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-semibold">
                                <i class="ri-building-line me-2 text-primary"></i>
                                Tambah Divisi Baru
                            </h5>
                            <p class="text-muted mb-0 fs-7">Tambahkan divisi magang baru</p>
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
                    <form action="{{ route('super_admin.divisi.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Divisi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-building-line text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 @error('nama_divisi') is-invalid @enderror"
                                       name="nama_divisi"
                                       value="{{ old('nama_divisi') }}"
                                       required>
                            </div>
                            @error('nama_divisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Deskripsi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-file-text-line text-muted"></i>
                                </span>
                                <textarea class="form-control border-start-0 @error('deskripsi') is-invalid @enderror"
                                          name="deskripsi" 
                                          rows="3">{{ old('deskripsi') }}</textarea>
                            </div>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-save-line me-1"></i>
                                Simpan Divisi
                            </button>
                            <a href="{{ route('super_admin.divisi.index') }}" class="btn btn-light px-4">
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