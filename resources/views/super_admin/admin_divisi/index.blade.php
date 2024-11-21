@extends('layouts.app')

@section('title', 'Manajemen Admin Divisi')

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
                                Manajemen Admin Divisi
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola admin untuk setiap divisi</p>
                        </div>
                        <a href="{{ route('super_admin.admin-divisi.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i>
                            Tambah Admin Divisi
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
                                    <th class="px-3 py-2">Nama</th>
                                    <th class="px-3 py-2">Email</th>
                                    <th class="px-3 py-2">Divisi</th>
                                    <th class="px-3 py-2">Total Mahasiswa</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($adminDivisis as $index => $admin)
                                    <tr>
                                        <td class="px-3">{{ $index + 1 }}</td>
                                        <td class="px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle me-2">
                                                    <i class="ri-user-line text-primary"></i>
                                                </div>
                                                <span>{{ $admin->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3">{{ $admin->email }}</td>
                                        <td class="px-3">
                                            @if($admin->divisi)
                                                <span class="badge bg-info">{{ $admin->divisi->nama_divisi }}</span>
                                            @else
                                                <span class="badge bg-warning">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                        <td class="px-3">
                                            <span class="badge bg-secondary">
                                                {{ $admin->divisi ? $admin->divisi->users()->role('mahasiswa')->count() : 0 }} Mahasiswa
                                            </span>
                                        </td>
                                        <td class="px-3">
                                            <div class="btn-group">
                                                <a href="{{ route('super_admin.admin-divisi.edit', $admin->id) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="ri-edit-line me-1"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('super_admin.admin-divisi.destroy', $admin->id) }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin divisi ini?')">
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
                                            <i class="ri-user-settings-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Belum ada data admin divisi</span>
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
    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-group {
        gap: 0.5rem;
    }
</style>
@endsection 