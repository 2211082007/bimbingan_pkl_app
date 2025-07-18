@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Judul Halaman -->
    <h2>Tambah Jurusan</h2>

    {{-- Menampilkan pesan error jika ada validasi yang gagal --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {{-- Menampilkan semua pesan error --}}
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form untuk menambahkan data jurusan --}}
    <form action="{{ route('jurusan.store') }}" method="POST">
        @csrf

        {{-- ID Jurusan (tidak perlu diisi manual, biasanya auto-increment) --}}
        <div class="mb-3">
            <label for="id_jurusan" class="form-label">ID Jurusan</label>
            <input type="number" name="id_jurusan" id="id_jurusan" class="form-control" disabled>
        </div>

        {{-- Kode Jurusan --}}
        <div class="mb-3">
            <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" id="kode_jurusan" class="form-control" required>
        </div>

        {{-- Nama Jurusan --}}
        <div class="mb-3">
            <label for="jurusan" class="form-label">Nama Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" class="form-control" required>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
