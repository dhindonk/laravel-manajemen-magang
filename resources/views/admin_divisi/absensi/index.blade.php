@extends('layouts.app')

@section('title', 'Manajemen Absensi')

@section('content')
<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-semibold">
                                <i class="ri-calendar-check-line me-2 text-primary"></i>
                                Manajemen Absensi
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola absensi mahasiswa di divisi Anda</p>
                        </div>
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
                                    <th class="px-3 py-2">Tanggal</th>
                                    <th class="px-3 py-2">Nama Mahasiswa</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Bukti</th>
                                    <th class="px-3 py-2">Keterangan</th>
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
                                            <a href="{{ Storage::url($absen->bukti_foto) }}" 
                                               class="btn btn-light btn-sm"
                                               target="_blank">
                                                <i class="ri-image-line me-1"></i>
                                                Lihat Bukti
                                            </a>
                                        </td>
                                        <td class="px-3">
                                            <span class="text-muted">{{ $absen->keterangan ?? '-' }}</span>
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
                                                <form action="{{ route('admin_divisi.absensi.verify', $absen->id) }}" 
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-success btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin memverifikasi absensi ini?')">
                                                        <i class="ri-check-line me-1"></i>
                                                        Verifikasi
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-3 text-muted">
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