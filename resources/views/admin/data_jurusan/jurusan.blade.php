@extends('layouts.master')

@section('content')

<!-- Wrapper Card untuk konten utama -->
<div class="card">
    <div class="card-body">

        <!-- Judul halaman -->
        <h3 class="card-title" style="font-weight: bold;">Data Jurusan</h3>

        <!-- Tombol tambah jurusan -->
        <div class="mt-2">
            <a href="{{ route('jurusan.create') }}" class="btn btn-primary">
                <i class="typcn typcn-plus"></i> Add New Jurusan
            </a>
        </div>

        <!-- Tabel Data Jurusan -->
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr class="table-success text-center">
                        <th>NO</th>               {{-- Nomor urut --}}
                        <th>Kode</th>             {{-- Kode jurusan --}}
                        <th>Jurusan</th>          {{-- Nama jurusan --}}
                        <th>Aksi</th>             {{-- Kolom untuk tombol edit & hapus --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_jurusan as $index => $data)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $data->kode_jurusan }}</td>
                            <td>{{ $data->jurusan }}</td>
                            <td class="text-center">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('data_jurusan.edit_jurusan', $data->id_jurusan) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Tombol Delete --}}
                                <form action="{{ route('jurusan.destroy', $data->id_jurusan) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin untuk menghapus?')">
                                        <i class="fas fa-trash"></i> Delete
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

@endsection
