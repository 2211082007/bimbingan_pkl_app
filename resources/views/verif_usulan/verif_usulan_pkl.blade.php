@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title" style="font-weight: bold;">Verifikasi Usulan PKL</h3>
<!-- Tabel Belum Diverifikasi -->
<div class="card">
    <div class="card-body">
<h4 class="mt-1">Belum Diverifikasi</h4>
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-warning text-center">
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Nama Perusahaan</th>
                <th>Alamat Perusahaan</th>
                <th>Upload File</th>
                <th>Konfirmasi</th>
                <th>Dosen Pembimbing</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($belumDikonfirmasi as $index => $data)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $data->mahasiswa->nama }}</td>
                    <td>{{ $data->nama_perusahaan }}</td>
                    <td>{{ $data->deskripsi }}</td>
                    <td>
                        @if ($data->upload_file)
                            <a href="{{ asset('storage/uploads/usulan_files/' . $data->upload_file) }}" target="_blank">Lihat File</a>
                        @else
                            <span class="text-muted">File tidak tersedia</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-warning">Belum Dikonfirmasi</span>
                    </td>
                    <td>
                        {{ $data->pembimbing_id ? ($data->dosen->nama ?? 'Dosen tidak ditemukan') : 'Belum ada pembimbing' }}
                    </td>
                    <td class="text-center">
                        <!-- Tombol Verifikasi -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $data->id_usulan }}">
                            <i class="fas fa-check"></i> Verifikasi
                        </button>
                    </td>
                </tr>

                <!-- Modal Verifikasi -->
                <div class="modal fade" id="konfirmasiModal{{ $data->id_usulan }}" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('verif_usulan_pkl.konfirmasi', $data->id_usulan) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="konfirmasiModalLabel">Verifikasi Usulan PKL</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="pembimbing_id">Pilih Dosen Pembimbing</label>
                                        <select class="form-control" name="pembimbing_id" required>
                                            <option value="">-- Pilih Dosen Pembimbing --</option>
                                            @foreach ($dosenList as $dosen)
                                                <option value="{{ $dosen->id_dosen }}">{{ $dosen->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            @endforeach

        </tbody>
    </table>
</div>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body">
        <!-- Tabel Sudah Diverifikasi -->
        <h4 class="mt-1">Sudah Diverifikasi</h4>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-success text-center">
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Nama Perusahaan</th>
                        <th>Alamat Perusahaan</th>
                        <th>Upload File</th>
                        <th>Konfirmasi</th>
                        <th>Dosen Pembimbing</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sudahDikonfirmasi as $index => $data)

                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $data->mahasiswa->nama }}</td>
                            <td>{{ $data->nama_perusahaan }}</td>
                            <td>{{ $data->deskripsi }}</td>
                            <td>
                                @if ($data->upload_file)
                                <a href="{{ asset('storage/uploads/usulan_files/' . $data->upload_file) }}" target="_blank">Lihat File</a>
                                @else
                                    <span class="text-muted">File tidak tersedia</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">Sudah Dikonfirmasi</span>
                            </td>
                            <td>
                                {{ $data->pembimbing_id ? ($data->dosen->nama ?? 'Dosen tidak ditemukan') : 'Belum ada pembimbing' }}
                            </td>
                            <td class="text-center">
                                <!-- Tombol Batalkan Verifikasi -->
                                <form action="{{ route('verif_usulan_pkl.batalkan', $data->id_usulan) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan verifikasi?')">
                                        <i class="fas fa-times"></i> Batalkan Verifikasi
                                    </button>
                                </form>
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

@endsection
