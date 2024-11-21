@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="container-fluid py-3">
    <!-- Welcome Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="welcome-header bg-gradient-primary text-white p-3 rounded-3">
                <h4 class="mb-1">
                    <i class="ri-dashboard-3-line me-2"></i>
                    Selamat Datang di Panel Super Admin
                </h4>
                <p class="mb-0 fs-6 opacity-75">Sistem Manajemen Praktek Lapangan</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-3">
        <!-- Total Divisi Card -->
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white rounded-2 me-3">
                            <i class="ri-building-line ri-lg"></i>
                        </div>
                        <div>
                            <p class="card-text text-muted mb-0 fs-7">Total Divisi</p>
                            <h5 class="card-title mb-0">{{ $totalDivisi }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Admin Divisi Card -->
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success text-white rounded-2 me-3">
                            <i class="ri-user-settings-line ri-lg"></i>
                        </div>
                        <div>
                            <p class="card-text text-muted mb-0 fs-7">Admin Divisi</p>
                            <h5 class="card-title mb-0">{{ $totalAdminDivisi }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Mahasiswa Card -->
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info text-white rounded-2 me-3">
                            <i class="ri-user-line ri-lg"></i>
                        </div>
                        <div>
                            <p class="card-text text-muted mb-0 fs-7">Total Mahasiswa</p>
                            <h5 class="card-title mb-0">{{ $totalMahasiswa }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Verification Card -->
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning text-white rounded-2 me-3">
                            <i class="ri-time-line ri-lg"></i>
                        </div>
                        <div>
                            <p class="card-text text-muted mb-0 fs-7">Pending Verifikasi</p>
                            <h5 class="card-title mb-0">{{ $pendingVerifikasi }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Mahasiswa Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="ri-user-add-line me-2 text-primary"></i>
                            Mahasiswa Terbaru
                        </h6>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Divisi</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestMahasiswa as $mahasiswa)
                                    <tr>
                                        <td>{{ $mahasiswa->name }}</td>
                                        <td>{{ $mahasiswa->email }}</td>
                                        <td>
                                            @if($mahasiswa->divisi)
                                                <span class="badge bg-info">{{ $mahasiswa->divisi->nama_divisi }}</span>
                                            @else
                                                <span class="badge bg-warning">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($mahasiswa->is_verified)
                                                <span class="badge bg-success">Terverifikasi</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $mahasiswa->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">Belum ada data mahasiswa</td>
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
    .welcome-header {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }

    .stats-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fs-7 {
        font-size: 0.875rem;
    }
</style>
@endsection 