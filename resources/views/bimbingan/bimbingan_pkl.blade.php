@extends('layouts.master')

@section('content')

    {{-- Judul Halaman --}}
    <h3 class="card-title mb-3" style="font-weight: bold;">Data Mahasiswa Bimbingan PKL</h3>

    {{-- Menampilkan pesan sukses jika ada session flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {{-- Validasi jika data kosong --}}
            @if (isset($pkl_pembimbing) && $pkl_pembimbing->isEmpty())
                <p>Tidak ada data mahasiswa bimbingan yang ditemukan.</p>
            @elseif (isset($pkl_mahasiswa) && $pkl_mahasiswa->isEmpty())
                <p>Tidak ada data mahasiswa PKL yang ditemukan.</p>
            @else

            {{-- Tabel berisi daftar mahasiswa PKL bimbingan --}}
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-success text-center">
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Prodi</th>
                            <th>Nama Perusahaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menampilkan data dari koleksi $pkl_pembimbing --}}
                        @foreach ($pkl_pembimbing as $index => $data)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>

                                {{-- Ambil nama mahasiswa dari relasi --}}
                                <td>{{ $data->mahasiswa->nama }}</td>

                                {{-- Ambil nama prodi dari relasi mahasiswa -> prodi --}}
                                <td>{{ $data->mahasiswa->prodi->prodi }}</td>

                                {{-- Nama perusahaan tempat PKL --}}
                                <td>{{ $data->nama_perusahaan }}</td>

                                {{-- Aksi: tombol untuk melihat logbook mahasiswa --}}
                                <td class="text-center">
                                    <a href="{{ route('logbook.view', $data->mahasiswa->id_mhs) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-book"></i> Logbook
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @endif
        </div>
    </div>

@endsection
