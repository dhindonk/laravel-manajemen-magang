@extends('layouts.app')

@section('title', 'Verifikasi Absensi')

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
                                Verifikasi Absensi
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola verifikasi absensi mahasiswa magang</p>
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
                                    <th class="px-3 py-2">Nama Mahasiswa</th>
                                    <th class="px-3 py-2">Tanggal</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Keterangan</th>
                                    <th class="px-3 py-2">Bukti</th>
                                    <th class="px-3 py-2">Status Verifikasi</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absens as $index => $absen)
                                    <tr>
                                        <td class="px-3">{{ $index + 1 }}</td>
                                        <td class="px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle me-2">
                                                    <i class="ri-user-line text-primary"></i>
                                                </div>
                                                <div>
                                                    <span class="d-block">{{ $absen->user->name }}</span>
                                                    <small class="text-muted">{{ $absen->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3">{{ $absen->tanggal->format('d/m/Y') }}</td>
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
                                                    <i class="ri-error-warning-line me-1"></i>
                                                    Sakit
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3">{{ $absen->keterangan ?? '-' }}</td>
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
                                        <td class="px-3">
                                            @if(!$absen->is_verified)
                                                <form action="{{ route('admin.absens.verify', $absen->id) }}" 
                                                      method="POST" 
                                                      class="d-inline verify-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="ri-check-line me-1"></i>
                                                        Verifikasi
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="ri-check-double-line"></i>
                                                    Sudah Diverifikasi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-3 text-muted">
                                            <i class="ri-calendar-todo-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Tidak ada absensi yang perlu diverifikasi</span>
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

    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .swal-actions {
        gap: 10px;
    }
</style>
@endsection

@push('scripts')
<script>
    // Notifikasi Sweet Alert
    @if(session('message'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('message') }}",
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: 'top-end'
        });
    @endif

    // Konfirmasi verifikasi absensi
    document.querySelectorAll('.verify-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Verifikasi',
                text: 'Apakah Anda yakin ingin memverifikasi absensi ini?',
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

    // DataTable initialization
    $(document).ready(function() {
        if ($('.table').length > 0) {
            $('.table').DataTable({
                "pageLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<",
                        "next": ">"
                    }
                }
            });
        }
    });
</script>
@endpush
