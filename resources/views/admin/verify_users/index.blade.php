@extends('layouts.app')

@section('title', 'Verifikasi Mahasiswa')
@push('css')
<style>
    .swal-actions {
        gap: 10px;
    }
</style>
@endpush

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
                                <i class="ri-user-follow-line me-2 text-primary"></i>
                                Verifikasi Mahasiswa
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola verifikasi pendaftaran mahasiswa magang</p>
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
                                    <th class="px-3 py-2">Dokumen</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td class="px-3">{{ $index + 1 }}</td>
                                        <td class="px-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle me-2">
                                                    <i class="ri-user-line text-primary"></i>
                                                </div>
                                                <div>
                                                    <span class="d-block">{{ $user->name }}</span>
                                                    <small class="text-muted">{{ $user->no_tlpn }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3">{{ $user->email }}</td>
                                        <td class="px-3">{{ $user->asal_kampus }}</td>
                                        <td class="px-3">
                                            <div class="d-flex gap-2">
                                                @if ($user->surat_kampus)
                                                    <a href="{{ Storage::url($user->surat_kampus) }}"
                                                        class="btn btn-light btn-sm" target="_blank">
                                                        <i class="ri-file-text-line me-1"></i>
                                                        Surat Kampus
                                                    </a>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger">
                                                        <i class="ri-close-circle-line"></i> Belum Upload
                                                    </span>
                                                @endif

                                                @if ($user->surat_bakesbangpol)
                                                    <a href="{{ Storage::url($user->surat_bakesbangpol) }}"
                                                        class="btn btn-light btn-sm" target="_blank">
                                                        <i class="ri-file-text-line me-1"></i>
                                                        Surat Bakesbangpol
                                                    </a>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger">
                                                        <i class="ri-close-circle-line"></i> Belum Upload
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-3">
                                            @if($user->is_verified)
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line"></i> Terverifikasi
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line"></i> Menunggu Verifikasi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3">
                                            @if(!$user->is_verified)
                                                <div class="d-flex gap-1">
                                                    @if(!$user->suratBalasan)
                                                        <a href="{{ route('admin.surat_balasans.create', $user->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="ri-upload-2-line me-1"></i>
                                                            Upload Surat
                                                        </a>
                                                    @endif
                                                    
                                                    @if($user->suratBalasan)
                                                        <form action="{{ route('admin.verify.user', $user->id) }}"
                                                            method="POST" class="d-inline verify-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="ri-check-line me-1"></i>
                                                                Verifikasi
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="ri-check-double-line me-1"></i> Sudah Diverifikasi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3 text-muted">
                                            <i class="ri-inbox-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Tidak ada mahasiswa yang perlu diverifikasi</span>
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
</style>

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
            // Debug: Log URL WhatsApp
            console.log("WhatsApp URL:", "{{ session('whatsapp_url') }}");
            
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
</script>
@endpush
@endsection