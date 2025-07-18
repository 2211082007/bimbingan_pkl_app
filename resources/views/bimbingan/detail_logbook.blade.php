@extends('layouts.master')

@section('content')
    <h3 class="card-title mb-3" style="font-weight: bold;">Detail Logbook PKL</h3>

    <div class="row">
        <!-- First Column: Student and Company Information -->
        <div class="col-12 col-md-4 col-lg-3"> <!-- Adjusted column sizes for responsiveness -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5><b>Informasi</b></h5>
                    <!-- Default Image above Student Information -->
                    <div class="text-center mb-3">
                        @if(Auth::user()->mahasiswa && Auth::user()->mahasiswa->image)
                            <img src="{{ asset('images/mahasiswa/' . Auth::user()->mahasiswa->image) }}"
                                alt="Foto Mahasiswa"
                                class="img-fluid rounded-circle"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/img/profile-default.png') }}"
                                alt="Default Profile Image"
                                class="img-fluid rounded-circle"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                    </div>

                    <!-- Menampilkan data UsulanPKL -->
                    <h6><b>Mahasiswa:</b> {{ $data_mhs->nama }}</h6>
                    <h6><b>Tempat PKL:</b> {{ $data_usulanpkl->nama_perusahaan ?? 'Datat tidak ada' }}</h6>
                    <h6><b>Dosen Pembimbing:</b> {{ $data_usulanpkl->dosen->nama ?? 'Data tidak ada' }}</h6>
                </div>
            </div>
        </div>

        <!-- Second Column: Logbook Table -->
        <div class="col-12 col-md-8 col-lg-9"> <!-- Adjusted column sizes for responsiveness -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 style="font-weight: bold;">Laporan Bimbingan PKL</h5>
                    @hasrole('mahasiswaPkl')
                        <div class="mt-2 mb-2">
                            <a href="{{ route('bimbinganPkl.create', ['id' => $data_usulanpkl->id_usulan]) }}"
                                class="btn btn-primary">Tambah</a>
                        </div>
                    @endhasrole
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-success text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kegiatan Selama Seminggu</th>
                                    <th>Laporan</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    @hasrole('mahasiswaPkl')
                                        <th>Aksi</th>
                                    @endhasrole
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_bimbinganPkl as $index => $laporan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
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
                                            @if ($laporan->verif == 0)
                                                Belum Diverifikasi
                                            @elseif ($laporan->verif == 1)
                                                Disetujui
                                            @elseif ($laporan->verif == 2)
                                                Ditolak
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @hasrole('mahasiswaPkl')
                                                <a href="{{ route('bimbinganPkl.edit', $laporan->id_bimbinganPkl) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('bimbinganPkl.destroy', $laporan->id_bimbinganPkl) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin hapus?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endhasrole
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
