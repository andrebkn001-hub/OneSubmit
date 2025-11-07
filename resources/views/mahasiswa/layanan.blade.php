@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center">Layanan</h1>
            <p class="text-center text-muted">Unduh dokumen pedoman dan template terkait skripsi Program Studi Sistem Informasi</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Dokumen Skripsi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">No</th>
                                    <th>Nama Dokumen</th>
                                    <th class="text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $index => $file)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $file['name'] }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('mahasiswa.layanan.download', $file['filename']) }}"
                                           class="btn btn-success btn-sm"
                                           target="_blank">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-center">
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                <strong>Informasi:</strong> File PDF asli telah tersedia untuk diunduh.
            </div>
        </div>
    </div>
</div>
@endsection
