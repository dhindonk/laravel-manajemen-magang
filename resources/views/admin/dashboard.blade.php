@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid py-3">
        <!-- Welcome Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="welcome-header bg-gradient-primary text-white p-3 rounded-3">
                    <h4 class="mb-1">
                        <i class="ri-dashboard-3-line me-2"></i>
                        Selamat Datang di Panel Admin
                    </h4>
                    <p class="mb-0 fs-6 opacity-75">Sistem Manajemen Praktek Lapangan</p>
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
                                <i class="ri-team-line ri-lg"></i>
                            </div>
                            <div>
                                <p class="card-text text-muted mb-0 fs-7">Total Mahasiswa</p>
                                <h5 class="card-title mb-0">{{ $totalMahasiswa }}</h5>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 3px;">
                            <div class="progress-bar bg-primary" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Verification Card -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-warning text-white rounded-2 me-3">
                                <i class="ri-time-line ri-lg"></i>
                            </div>
                            <div>
                                <p class="card-text text-muted mb-0 fs-7">Menunggu Verifikasi</p>
                                <h5 class="card-title mb-0">{{ $pendingVerifikasi }}</h5>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 3px;">
                            <div class="progress-bar bg-warning" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Verification Card -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-success text-white rounded-2 me-3">
                                <i class="ri-file-list-3-line ri-lg"></i>
                            </div>
                            <div>
                                <p class="card-text text-muted mb-0 fs-7">Absensi Pending</p>
                                <h5 class="card-title mb-0">{{ $absensiHariIni }}</h5>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 3px;">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Students Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">
                                <i class="ri-user-follow-line me-2 text-primary"></i>
                                Mahasiswa Menunggu Verifikasi
                            </h6>
                            <div>
                                <button onclick="window.location.reload()" 
                                        class="btn btn-light btn-sm me-2">
                                    <i class="ri-refresh-line me-1"></i>
                                    Refresh
                                </button>
                                <a href="{{ route('admin.verify.users') }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="ri-eye-line me-1"></i>
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-3 py-2">No</th>
                                        <th class="px-3 py-2">Nama</th>
                                        <th class="px-3 py-2">Email</th>
                                        <th class="px-3 py-2">Asal Kampus</th>
                                        <th class="px-3 py-2">Status Dokumen</th>
                                        <th class="px-3 py-2">Status Surat</th>
                                        <th class="px-3 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mahasiswaTerbaru as $index => $user)
                                        <tr>
                                            <td class="px-3">{{ $index + 1 }}</td>
                                            <td class="px-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle me-2">
                                                        <i class="ri-user-line text-primary"></i>
                                                    </div>
                                                    <span>{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3">{{ $user->email }}</td>
                                            <td class="px-3">{{ $user->asal_kampus }}</td>
                                            <td class="px-3">
                                                @if ($user->surat_kampus && $user->surat_bakesbangpol)
                                                    <span class="badge bg-success-subtle text-success">
                                                        <i class="ri-checkbox-circle-line"></i> Lengkap
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger">
                                                        <i class="ri-close-circle-line"></i> Belum Lengkap
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3">
                                                @if ($user->suratBalasan)
                                                    <span class="badge bg-success-subtle text-success">
                                                        <i class="ri-checkbox-circle-line"></i> Sudah Upload
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        <i class="ri-time-line"></i> Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3">
                                                @if (!$user->suratBalasan)
                                                    <a href="{{ route('admin.surat_balasans.create', $user->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="ri-upload-2-line"></i> Upload
                                                    </a>
                                                @else
                                                    <form action="{{ route('admin.verify.user', $user->id) }}"
                                                        method="POST" class="d-inline verify-form">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="ri-check-line me-1"></i> Verifikasi
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-3 text-muted">
                                                <i class="ri-inbox-line ri-2x mb-2 d-block"></i>
                                                <span class="fs-7">Tidak ada mahasiswa yang menunggu verifikasi</span>
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
        .welcome-header {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }

        .welcome-header h4 {
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .welcome-header p {
            font-weight: 400;
            letter-spacing: -0.1px;
        }

        .stats-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            transition: box-shadow 0.2s ease;
            border: 1px solid rgba(0,0,0,.085);
            border-radius: 8px;
        }

        .card:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .card-title {
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        .table th {
            font-weight: 500;
            font-size: 0.8125rem;
            text-transform: none;
            letter-spacing: -0.1px;
            color: #4a5568;
        }

        .table td {
            font-size: 0.875rem;
            color: #2d3748;
        }

        .fs-7 {
            font-size: 0.875rem;
            font-weight: 400;
        }

        .badge {
            font-weight: 500;
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            letter-spacing: 0;
        }

        .btn-sm {
            font-size: 0.8125rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
        }

        .progress {
            background-color: rgba(0,0,0,.04);
            border-radius: 100px;
        }

        .progress-bar {
            border-radius: 100px;
        }

        @media (max-width: 768px) {
            .welcome-header {
                text-align: center;
                padding: 1.5rem !important;
            }

            .stats-icon {
                width: 38px;
                height: 38px;
            }

            .card-body {
                padding: 1rem;
            }
        }
    </style>
@endsection

@push('scripts')
<script>
    // Notifikasi Sweet Alert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: 'top-end'
        }).then(() => {
            // Redirect ke WhatsApp setelah notifikasi sukses
            @if(session('whatsapp_url'))
                window.open("{{ session('whatsapp_url') }}", "_blank");
            @endif
        });
    @endif

    // Konfirmasi verifikasi
    document.querySelectorAll('.verify-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Verifikasi',
                text: 'Apakah Anda yakin ingin memverifikasi mahasiswa ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: '<i class="ri-check-line me-1"></i> Ya, Verifikasi!',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                    actions: 'swal-actions'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading state
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    this.submit();
                }
            });
        });
    });

    // Auto refresh setiap 30 detik
    setTimeout(function(){
        window.location.reload();
    }, 30000);
</script>
@endpush

@push('css')
<style>
    .swal-actions {
        gap: 10px;
    }
</style>
@endpush
