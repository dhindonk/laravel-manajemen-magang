@extends('layouts.app')

@section('title', 'Daftar Laporan')

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
                                <i class="ri-file-list-3-line me-2 text-primary"></i>
                                Daftar Laporan
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola laporan kegiatan magang Anda</p>
                        </div>
                        <a href="{{ route('laporans.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i>
                            Upload Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('message'))
        <div class="alert alert-success py-2 mb-3">
            <i class="ri-checkbox-circle-line me-2"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-3 py-2">No</th>
                                    <th class="px-3 py-2">Tanggal Upload</th>
                                    <th class="px-3 py-2">File Laporan</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Keterangan</th>
                                    <th class="px-3 py-2">Surat Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $index => $laporan)
                                    <tr>
                                        <td class="px-3">{{ $index + 1 }}</td>
                                        <td class="px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-icon bg-light rounded-2 p-2 me-2">
                                                    <i class="ri-calendar-line text-primary"></i>
                                                </div>
                                                <div>
                                                    <span class="d-block">{{ $laporan->created_at->format('d M Y') }}</span>
                                                    <small class="text-muted">{{ $laporan->created_at->format('H:i') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3">
                                            <a href="{{ Storage::url($laporan->file_laporan) }}" 
                                               class="btn btn-light btn-sm" 
                                               target="_blank">
                                                <i class="ri-file-text-line me-1"></i>
                                                Lihat Laporan
                                            </a>
                                        </td>
                                        <td class="px-3">
                                            @if($laporan->is_verified)
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>
                                                    Diterima
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line me-1"></i>
                                                    {{ ucfirst($laporan->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3">
                                            <span class="text-muted">{{ $laporan->keterangan ?? '-' }}</span>
                                        </td>
                                        <td class="px-3">
                                            @if($laporan->suratSelesai)
                                                <a href="{{ Storage::url($laporan->suratSelesai->file_surat) }}" 
                                                   class="btn btn-success btn-sm"
                                                   download="Surat_Selesai_Magang.pdf">
                                                    <i class="ri-download-line me-1"></i>
                                                    Download Surat
                                                </a>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">
                                                    <i class="ri-time-line me-1"></i>
                                                    Menunggu Surat
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-muted">
                                            <i class="ri-file-list-3-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Belum ada laporan yang diupload</span>
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
    .calendar-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fs-7 {
        font-size: 0.875rem;
    }

    .badge {
        font-weight: 500;
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .btn-sm {
        font-size: 0.8125rem;
        font-weight: 500;
        padding: 0.25rem 0.75rem;
    }

    .table th {
        font-weight: 500;
        font-size: 0.8125rem;
        color: #4a5568;
    }

    .table td {
        font-size: 0.875rem;
        color: #2d3748;
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }

    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #dde0e3;
    }

    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-secondary-subtle {
        background-color: rgba(108, 117, 125, 0.1);
    }
</style>
@endsection
