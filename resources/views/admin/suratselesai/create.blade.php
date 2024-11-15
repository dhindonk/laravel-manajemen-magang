@extends('layouts.app')

@section('title', 'Buat Surat Selesai')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Buat Surat Selesai Magang</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6>Detail Mahasiswa:</h6>
                    <table class="table table-sm">
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $laporan->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{ $laporan->user->email }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Upload Laporan</td>
                            <td>: {{ $laporan->created_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <form action="{{ route('admin.suratselesai.store', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="file_surat" class="form-label">File Surat (PDF)</label>
                    <input type="file" class="form-control @error('file_surat') is-invalid @enderror"
                           id="file_surat" name="file_surat">
                    @error('file_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                    <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror"
                           id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', now()->format('Y-m-d')) }}">
                    @error('tanggal_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Buat Surat Selesai</button>
                    <a href="{{ route('admin.suratselesai.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
