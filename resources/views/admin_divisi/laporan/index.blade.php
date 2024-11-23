@extends('layouts.app')

@section('title', 'Manajemen Laporan')

@section('content')
<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-semibold">
                                <i class="ri-file-list-3-line me-2 text-primary"></i>
                                Manajemen Laporan
                            </h5>
                            <p class="text-muted mb-0 fs-7">Kelola laporan mahasiswa di divisi Anda</p>
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
                                    <th class="px-3 py-2">Tanggal Upload</th>
                                    <th class="px-3 py-2">Nama Mahasiswa</th>
                                    <th class="px-3 py-2">File Laporan</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Keterangan</th>
                                    <th class="px-3 py-2">Aksi</th>
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
                                        <td class="px-3">
                                            <a href="{{ Storage::url($laporan->file_laporan) }}" 
                                               class="btn btn-light btn-sm"
                                               target="_blank">
                                                <i class="ri-file-text-line me-1"></i>
                                                Lihat Laporan
                                            </a>
                                        </td>
                                        <td class="px-3">
                                            @if($laporan->status == 'diterima')
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="ri-checkbox-circle-line me-1"></i>
                                                    Diterima
                                                </span>
                                            @elseif($laporan->status == 'ditolak')
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="ri-close-circle-line me-1"></i>
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">
                                                    <i class="ri-time-line me-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-3">
                                            <span class="text-muted">{{ $laporan->keterangan ?? '-' }}</span>
                                        </td>
                                        <td class="px-3">
                                            @if($laporan->status == 'pending')
                                                <div class="btn-group">
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm"
                                                            onclick="showVerifyModal('{{ $laporan->id }}')">
                                                        <i class="ri-check-line me-1"></i>
                                                        Verifikasi
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm"
                                                            onclick="showRejectModal('{{ $laporan->id }}')">
                                                        <i class="ri-close-line me-1"></i>
                                                        Tolak
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3 text-muted">
                                            <i class="ri-file-list-3-line ri-2x mb-2 d-block"></i>
                                            <span class="fs-7">Belum ada data laporan</span>
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

<!-- Modal Tolak Laporan -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" 
                                 name="keterangan" 
                                 rows="3" 
                                 required
                                 placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ri-close-line me-1"></i>
                        Tolak Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Di dalam modal verifikasi laporan -->
<div class="modal fade" id="verifyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="verifyForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Surat Selesai</label>
                        <input type="file" 
                               class="form-control @error('file_surat') is-invalid @enderror" 
                               name="file_surat"
                               accept=".pdf"
                               required>
                        <small class="text-muted">Format: PDF, Maksimal 2MB</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Surat</label>
                        <input type="date" 
                               class="form-control @error('tanggal_surat') is-invalid @enderror"
                               name="tanggal_surat"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" 
                                 name="keterangan" 
                                 rows="3"
                                 placeholder="Masukkan keterangan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-check-line me-1"></i>
                        Verifikasi & Upload Surat
                    </button>
                </div>
            </form>
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

    .btn-group {
        gap: 0.5rem;
    }
</style>

@push('scripts')
<script>
    function showRejectModal(id) {
        const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
        const form = document.getElementById('rejectForm');
        form.action = "{{ url('admin-divisi/laporan') }}/" + id + "/reject";
        modal.show();
    }

    function showVerifyModal(id) {
        const modal = new bootstrap.Modal(document.getElementById('verifyModal'));
        const form = document.getElementById('verifyForm');
        form.action = "{{ url('admin-divisi/laporan') }}/" + id + "/verify";
        modal.show();
    }

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