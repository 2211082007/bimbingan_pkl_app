@extends('layouts.master')

@section('content')
    <h3 class="card-title mb-3" style="font-weight: bold;">Verifikasi Bimbingan PKL Mahasiswa</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Tabel Data Belum Diverifikasi -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 style="font-weight: bold;">Data Belum Diverifikasi</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-warning text-center">
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Laporan</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_belumVerif as $index => $laporan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $laporan->usulan_pkl->mahasiswa->nama }}</td>
                                        <td>{{ $laporan->usulan_pkl->nama_perusahaan }}</td>
                                        <td>{{ $laporan->tgl_awal }} - {{ $laporan->tgl_akhir }}</td>
                                        <td>{{ $laporan->kegiatan }}</td>
                                        <td>
                                            @if ($laporan->laporan)
                                                <a href="{{ asset('storage/' . $laporan->laporan) }}" target="_blank">Lihat
                                                    File</a>
                                            @else
                                                <span class="text-muted">File tidak tersedia</span>
                                            @endif
                                        </td>
                                        <td>{{ $laporan->catatan }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#setujuModal-{{ $laporan->id_bimbinganPkl }}">
                                                <i class="fas fa-check"></i> Setuju
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#tolakModal-{{ $laporan->id_bimbinganPkl }}">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Setuju -->
                                    <div class="modal fade" id="setujuModal-{{ $laporan->id_bimbinganPkl }}"
                                        tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('verif.bimbinganPkl', $laporan->id_bimbinganPkl) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="verif" value="1">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Setujui Bimbingan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="catatan">Catatan:</label>
                                                        <textarea name="catatan" id="catatan" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Tolak -->
                                    <div class="modal fade" id="tolakModal-{{ $laporan->id_bimbinganPkl }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('verif.bimbinganPkl', $laporan->id_bimbinganPkl) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="verif" value="2">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tolak Bimbingan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="catatan">Catatan:</label>
                                                        <textarea name="catatan" id="catatan" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Sudah Diverifikasi -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 style="font-weight: bold;">Data Sudah Diverifikasi</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-success text-center">
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Laporan</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_sudahVerif as $index => $laporan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $laporan->usulan_pkl->mahasiswa->nama }}</td>
                                        <td>{{ $laporan->usulan_pkl->nama_perusahaan }}</td>
                                        <td>{{ $laporan->tgl_awal }} - {{ $laporan->tgl_akhir }}</td>
                                        <td>{{ $laporan->kegiatan }}</td>
                                        <td>
                                            @if ($laporan->laporan)
                                                <a href="{{ asset('storage/' . $laporan->laporan) }}" target="_blank">Lihat
                                                    File</a>
                                            @else
                                                <span class="text-muted">File tidak tersedia</span>
                                            @endif
                                        </td>
                                        <td>{{ $laporan->catatan }}</td>
                                        <td>
                                            @if ($laporan->verif == 1)
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($laporan->verif == 2)
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('batal.verif', $laporan->id_bimbinganPkl) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT') 
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-undo"></i> Batal
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
