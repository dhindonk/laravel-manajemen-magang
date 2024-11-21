@extends('layouts.app')

@section('title', 'Manajemen Divisi')

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
                                Manajemen Divisi
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola divisi magang</p>
                        </div>
                        <a href="{{ route('super_admin.divisi.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i>
                            Tambah Divisi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-3 py-2">No</th>
                                    <th class="px-3 py-2">Nama Divisi</th>
                                    <th class="px-3 py-2">Deskripsi</th>
                                    <th class="px-3 py-2">Admin Divisi</th>
                                    <th class="px-3 py-2">Total Mahasiswa</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($divisis as $index => $divisi)
                                    <tr>
                                        <td class="px-3">{{ $index + 1 }}</td>
                                        <td class="px-3">{{ $divisi->nama_divisi }}</td>
                                        <td class="px-3">{{ $divisi->deskripsi ?? '-' }}</td>
                                        <td class="px-3">
                                            @forelse($divisi->adminDivisi as $admin)
                                                <span class="badge bg-info">{{ $admin->name }}</span>
                                            @empty
                                                <span class="badge bg-warning">Belum ada admin</span>
                                            @endforelse
                                        </td>
                                        <td class="px-3">
                                            <span class="badge bg-secondary">
                                                {{ $divisi->users()->role('mahasiswa')->count() }} Mahasiswa
                                            </span>
                                        </td>
                                        <td class="px-3">
                                            <div class="btn-group">
                                                <a href="{{ route('super_admin.divisi.edit', $divisi->id) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="ri-edit-line me-1"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('super_admin.divisi.destroy', $divisi->id) }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="ri-delete-bin-line me-1"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-muted">
                                            <i class="ri-folder-info-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Belum ada data divisi</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-group {
        gap: 0.5rem;
    }
</style>
@endsection 