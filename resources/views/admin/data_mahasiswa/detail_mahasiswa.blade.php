@extends('layouts.master')

@section('content')
    <!-- Container utama -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <!-- Judul Halaman -->
                <h5 class="card-title fw-semibold mb-4">Detail Mahasiswa</h5>

                <div class="row">

                    <!-- Kolom kiri: Foto Mahasiswa -->
                    <div class="col-md-4 text-center">
                        <h6>Foto Mahasiswa</h6>
                        @if ($mahasiswa->image)
                            {{-- Jika ada gambar, tampilkan --}}
                            <img src="{{ asset('images/mahasiswa/' . $mahasiswa->image) }}"
                                 alt="Gambar Mahasiswa" class="img-center" style="max-width: 150px;">
                        @else
                            {{-- Jika tidak ada gambar --}}
                            <p>Tidak ada gambar yang di-upload.</p>
                        @endif
                    </div>

                    <!-- Kolom kanan: Detail informasi mahasiswa -->
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th>NIM</th> {{-- Nomor Induk Mahasiswa --}}
                                <td>{{ $mahasiswa->nim }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $mahasiswa->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td>{{ $mahasiswa->jurusan }}</td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td>{{ $mahasiswa->prodi }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $mahasiswa->gender }}</td>
                            </tr>
                        </table>

                        <!-- Tombol kembali -->
                        <div class="mt-3">
                            <a href="{{ route('mahasiswa') }}" class="btn btn-primary">Kembali</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
