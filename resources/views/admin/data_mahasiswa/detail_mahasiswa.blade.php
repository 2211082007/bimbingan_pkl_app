@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Detail Mahasiswa</h5>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <h6>Foto Mahasiswa</h6>
                        @if ($mahasiswa->image)
                        <img src="{{ asset('images/mahasiswa/' . $mahasiswa->image) }}"
                        alt="Gambar Mahasiswa" class="img-center" style="max-width: 150px;">

                        @else
                            <p>Tidak ada gambar yang di-upload.</p>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th>NIM</th>
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
                        <div class="mt-3">
                            <a href="{{ route('mahasiswa') }}" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
