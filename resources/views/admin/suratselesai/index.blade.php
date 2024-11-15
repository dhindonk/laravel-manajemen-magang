@extends('layouts.app')

@section('title', 'Surat Selesai Magang')

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
                                    <i class="ri-file-paper-2-line me-2 text-primary"></i>
                                    Surat Selesai Magang
                                </h5>
                                <p class="text-muted mb-0 fs-7">Kelola surat keterangan selesai magang</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('message'))
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
                                        <th class="px-3 py-2">Nama Mahasiswa</th>
                                        <th class="px-3 py-2">Asal Kampus</th>
                                        <th class="px-3 py-2">File Laporan</th>
                                        <th class="px-3 py-2">Status</th>
                                        <th class="px-3 py-2">Surat Selesai</th>
                                        <th class="px-3 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($laporans as $index => $laporan)
                                        <tr>
                                            <td class="px-3">{{ $index + 1 }}</td>
                                            <td class="px-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle me-2">
                                                        <i class="ri-user-line text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <span class="d-block">{{ $laporan->user->name }}</span>
                                                        <small class="text-muted">{{ $laporan->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3">{{ $laporan->user->asal_kampus }}</td>
                                            <td class="px-3">
                                                <div class="btn-group">
                                                    <a href="{{ Storage::url($laporan->file_laporan) }}"
                                                        class="btn btn-light btn-sm" target="_blank">
                                                        <i class="ri-eye-line me-1"></i>
                                                        Preview
                                                    </a>
                                                    <a href="{{ Storage::url($laporan->file_laporan) }}"
                                                        class="btn btn-info btn-sm"
                                                        download="Laporan_{{ $laporan->user->name }}.pdf">
                                                        <i class="ri-download-line me-1"></i>
                                                        Download
                                                    </a>
                                                </div>
                                                <small class="d-block text-muted mt-1">
                                                    <i class="ri-calendar-line me-1"></i>
                                                    Upload: {{ $laporan->created_at->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td class="px-3">
                                                @if ($laporan->is_verified)
                                                    <span class="badge bg-success-subtle text-success">
                                                        <i class="ri-checkbox-circle-line me-1"></i>
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        <i class="ri-time-line me-1"></i>
                                                        Menunggu Surat
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3">
                                                @if ($laporan->suratSelesai)
                                                    <div class="d-flex flex-column">
                                                        <div class="btn-group">
                                                            <a href="{{ Storage::url($laporan->suratSelesai->file_surat) }}"
                                                                class="btn btn-light btn-sm" target="_blank">
                                                                <i class="ri-eye-line me-1"></i>
                                                                Preview
                                                            </a>
                                                            <a href="{{ Storage::url($laporan->suratSelesai->file_surat) }}"
                                                                class="btn btn-success btn-sm"
                                                                download="Surat_Selesai_{{ $laporan->user->name }}.pdf">
                                                                <i class="ri-download-line me-1"></i>
                                                                Download
                                                            </a>
                                                            <button type="button" class="btn btn-light btn-sm"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ $laporan->suratSelesai->keterangan ?? 'Tidak ada keterangan' }}">
                                                                <i class="ri-information-line"></i>
                                                            </button>
                                                        </div>
                                                        <small class="text-muted mt-1">
                                                            <i class="ri-calendar-line me-1"></i>
                                                            {{ $laporan->suratSelesai->tanggal_surat->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">
                                                        <i class="ri-file-forbid-line me-1"></i>
                                                        Belum Ada Surat
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3">
                                                @if (!$laporan->suratSelesai)
                                                    <a href="{{ route('admin.suratselesai.create', $laporan->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="ri-add-line me-1"></i>
                                                        Buat Surat
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-3 text-muted">
                                                <i class="ri-file-list-3-line ri-2x mb-2 d-block"></i>
                                                <span class="fs-7">Belum ada data surat selesai magang</span>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
    @endpush
@endsection
