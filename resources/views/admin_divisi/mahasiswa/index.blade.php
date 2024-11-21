@extends('layouts.app')

@section('title', 'Data Mahasiswa')

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
                                <i class="ri-user-line me-2 text-primary"></i>
                                Data Mahasiswa
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola data mahasiswa di divisi Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                    <th class="px-3 py-2">Nama</th>
                                    <th class="px-3 py-2">Email</th>
                                    <th class="px-3 py-2">Asal Kampus</th>
                                    <th class="px-3 py-2">No. Telepon</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Dokumen</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mahasiswas as $index => $mahasiswa)
                                    <tr>
                                        <td class="px-3">{{ $index + 1 }}</td>
                                        <td class="px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle me-2">
                                                    <i class="ri-user-line text-primary"></i>
                                                </div>
                                                <span>{{ $mahasiswa->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3">{{ $mahasiswa->email }}</td>
                                        <td class="px-3">{{ $mahasiswa->asal_kampus }}</td>
                                        <td class="px-3">{{ $mahasiswa->no_tlpn }}</td>
                                        <td class="px-3">
                                            @if($mahasiswa->is_verified)
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>
                                                    Terverifikasi
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line me-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3">
                                            <div class="btn-group">
                                                <a href="{{ Storage::url($mahasiswa->surat_kampus) }}" 
                                                   class="btn btn-light btn-sm"
                                                   target="_blank">
                                                    <i class="ri-file-text-line me-1"></i>
                                                    Surat Kampus
                                                </a>
                                                <a href="{{ Storage::url($mahasiswa->surat_bakesbangpol) }}" 
                                                   class="btn btn-light btn-sm"
                                                   target="_blank">
                                                    <i class="ri-file-text-line me-1"></i>
                                                    Surat Bakesbangpol
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-3">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu border-0 shadow-sm">
                                                    <li>
                                                        <a class="dropdown-item" href="#" 
                                                           onclick="viewAbsensi('{{ $mahasiswa->id }}')">
                                                            <i class="ri-calendar-check-line me-2"></i>
                                                            Riwayat Absensi
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                           onclick="viewLaporan('{{ $mahasiswa->id }}')">
                                                            <i class="ri-file-list-3-line me-2"></i>
                                                            Riwayat Laporan
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-3 text-muted">
                                            <i class="ri-user-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Belum ada data mahasiswa</span>
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

    .btn-group {
        gap: 0.5rem;
    }

    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-warning-subtle {
        background-color: rgba(255, 193, 7, 0.1);
    }
</style>

@push('scripts')
<script>
    function viewAbsensi(id) {
        // Implementasi untuk melihat riwayat absensi
        // Bisa menggunakan modal atau redirect ke halaman detail
    }

    function viewLaporan(id) {
        // Implementasi untuk melihat riwayat laporan
        // Bisa menggunakan modal atau redirect ke halaman detail
    }

    // Sweet Alert untuk notifikasi
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: 'top-end'
        });
    @endif
</script>
@endpush
@endsection 