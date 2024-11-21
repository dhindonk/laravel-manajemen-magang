@extends('layouts.app')

@section('title', 'Verifikasi Mahasiswa')

@section('content')
<div class="container-fluid py-3">
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
                            <p class="text-muted mb-0 fs-7">Kelola verifikasi dan penempatan divisi mahasiswa</p>
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
                                    <th class="px-3 py-2">Nama</th>
                                    <th class="px-3 py-2">Email</th>
                                    <th class="px-3 py-2">Asal Kampus</th>
                                    <th class="px-3 py-2">Dokumen</th>
                                    <th class="px-3 py-2">Status</th>
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
                                                <div>
                                                    <span class="d-block">{{ $mahasiswa->name }}</span>
                                                    <small class="text-muted">{{ $mahasiswa->no_tlpn }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3">{{ $mahasiswa->email }}</td>
                                        <td class="px-3">{{ $mahasiswa->asal_kampus }}</td>
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
                                            @if(!$mahasiswa->is_verified)
                                                <button type="button" 
                                                        class="btn btn-primary btn-sm"
                                                        onclick="showVerifyModal('{{ $mahasiswa->id }}')">
                                                    <i class="ri-check-line me-1"></i>
                                                    Verifikasi
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm"
                                                        onclick="showRejectModal('{{ $mahasiswa->id }}')">
                                                    <i class="ri-close-line me-1"></i>
                                                    Tolak
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3 text-muted">
                                            <i class="ri-user-follow-line ri-2x mb-2 d-block"></i>
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

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="verifyForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Divisi</label>
                        <select class="form-select" name="divisi_id" required>
                            <option value="">Pilih Divisi</option>
                            @foreach($divisis as $divisi)
                                <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-check-line me-1"></i>
                        Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" name="alasan_penolakan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ri-close-line me-1"></i>
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showVerifyModal(userId) {
        const modal = new bootstrap.Modal(document.getElementById('verifyModal'));
        const form = document.getElementById('verifyForm');
        form.action = "{{ url('super-admin/verify-user') }}/" + userId;
        modal.show();
    }

    function showRejectModal(userId) {
        const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
        const form = document.getElementById('rejectForm');
        form.action = "{{ url('super-admin/reject-user') }}/" + userId;
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