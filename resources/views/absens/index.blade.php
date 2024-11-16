@extends('layouts.app')

@section('title', 'Daftar Absensi')

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
                                <i class="ri-calendar-check-line me-2 text-primary"></i>
                                Daftar Absensi
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola absensi harian Anda</p>
                        </div>
                        <a href="{{ route('absens.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i>
                            Tambah Absensi
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
                                    <th class="px-3 py-2">Tanggal</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Keterangan</th>
                                    <th class="px-3 py-2">Bukti</th>
                                    <th class="px-3 py-2">Status Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absens as $index => $absen)
                                    <tr>
                                        <td class="px-3">{{ $index + 1 }}</td>
                                        <td class="px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-icon bg-light rounded-2 p-2 me-2">
                                                    <i class="ri-calendar-line text-primary"></i>
                                                </div>
                                                <div>
                                                    <span class="d-block">{{ $absen->tanggal->format('d M Y') }}</span>
                                                    <small class="text-muted">{{ $absen->tanggal->format('l') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3">
                                            @if($absen->status == 'Hadir')
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>
                                                    Hadir
                                                </span>
                                            @elseif($absen->status == 'Izin')
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line me-1"></i>
                                                    Izin
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="ri-medicine-bottle-line me-1"></i>
                                                    Sakit
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3">
                                            <span class="text-muted">{{ $absen->keterangan ?? '-' }}</span>
                                        </td>
                                        <td class="px-3">
                                            <a href="{{ Storage::url($absen->bukti_foto) }}" 
                                               class="btn btn-light btn-sm" 
                                               target="_blank">
                                                <i class="ri-image-line me-1"></i>
                                                Lihat Bukti
                                            </a>
                                        </td>
                                        <td class="px-3">
                                            @if($absen->is_verified)
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>
                                                    Terverifikasi
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line me-1"></i>
                                                    Menunggu Verifikasi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-muted">
                                            <i class="ri-calendar-todo-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Belum ada data absensi</span>
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

    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.1);
    }
</style>

@push('scripts')
<script>
    // Notifikasi Sweet Alert untuk sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Berhasil Login',
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'colored-toast'
            }
        });
    @endif

    // Notifikasi Sweet Alert untuk error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            showConfirmButton: true,
            confirmButtonColor: '#dc3545',
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });
    @endif

    // Konfirmasi sebelum submit form
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!this.classList.contains('confirmed')) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '<i class="ri-check-line me-1"></i> Ya, Simpan!',
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
                        this.classList.add('confirmed');
                        this.submit();
                    }
                });
            }
        });
    });
</script>

<style>
    .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
    }
    
    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }
    
    .colored-toast .swal2-title {
        color: white;
    }
    
    .colored-toast .swal2-close {
        color: white;
    }
    
    .colored-toast .swal2-html-container {
        color: white;
    }

    .swal2-popup {
        font-family: var(--primary-font) !important;
    }

    .swal-actions {
        gap: 8px;
    }

    .btn {
        font-weight: 500;
    }
</style>
@endpush
@endsection 