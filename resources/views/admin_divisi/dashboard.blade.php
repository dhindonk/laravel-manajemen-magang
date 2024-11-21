@extends('layouts.app')

@section('title', 'Dashboard Admin Divisi')

@section('content')
<div class="container-fluid py-3">
    <!-- Welcome Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="welcome-header bg-gradient-primary text-white p-3 rounded-3">
                <h4 class="mb-1">
                    <i class="ri-dashboard-3-line me-2"></i>
                    Selamat Datang di Panel Admin Divisi
                </h4>
                <p class="mb-0 fs-6 opacity-75">
                    Divisi: {{ $divisi->nama_divisi }}
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-3">
        <!-- Total Mahasiswa Card -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white rounded-2 me-3">
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

        <!-- Pending Absensi Card -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning text-white rounded-2 me-3">
                            <i class="ri-calendar-check-line ri-lg"></i>
                        </div>
                        <div>
                            <p class="card-text text-muted mb-0 fs-7">Pending Absensi</p>
                            <h5 class="card-title mb-0">{{ $pendingAbsensi }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Laporan Card -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info text-white rounded-2 me-3">
                            <i class="ri-file-list-3-line ri-lg"></i>
                        </div>
                        <div>
                            <p class="card-text text-muted mb-0 fs-7">Pending Laporan</p>
                            <h5 class="card-title mb-0">{{ $pendingLaporan }}</h5>
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
                            <i class="ri-user-line me-2 text-primary"></i>
                            Mahasiswa Terbaru
                        </h6>
                        <a href="{{ route('admin_divisi.mahasiswa') }}" class="btn btn-light btn-sm">
                            <i class="ri-eye-line me-1"></i>
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Asal Kampus</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestMahasiswa as $mahasiswa)
                                    <tr>
                                        <td>{{ $mahasiswa->name }}</td>
                                        <td>{{ $mahasiswa->email }}</td>
                                        <td>{{ $mahasiswa->asal_kampus }}</td>
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