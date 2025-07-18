@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Detail Dosen</h5>

            <div class="row">
                <!-- Bagian Foto -->
                <div class="col-md-4 text-center">
                    <h6><strong>Foto</strong></h6>
                    @if ($dosen->image)
                        <img src="{{ asset('images/dosen/' . $dosen->image) }}" alt="Foto Dosen"
                             class="img-fluid rounded" style="max-width: 200px;">
                    @else
                        <p>Tidak ada gambar yang di-upload.</p>
                    @endif
                </div>

                <!-- Bagian Informasi Dosen -->
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>NIDN</th>
                            <td>{{ $dosen->nidn }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td>{{ $dosen->nip }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $dosen->nama }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $dosen->gender }}</td>
                        </tr>
                        <tr>
                            <th>Tempat Lahir</th>
                            <td>{{ $dosen->tempt_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Pendidikan</th>
                            <td>{{ $dosen->pendidikan }}</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>{{ $dosen->jurusan }}</td>
                        </tr>
                        <tr>
                            <th>Prodi</th>
                            <td>{{ $dosen->prodi }}</td>
                        </tr>
                        <tr>
                            <th>Golongan</th>
                            <td>{{ $dosen->golongan }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $dosen->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $dosen->email }}</td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>{{ $dosen->no_hp }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $dosen->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                        </tr>
                    </table>

                    <!-- Tombol Kembali -->
                    <div class="mt-3">
                        <a href="{{ route('dosen') }}" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
