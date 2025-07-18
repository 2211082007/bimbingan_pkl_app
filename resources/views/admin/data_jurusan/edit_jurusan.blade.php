@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <!-- Judul Halaman -->
            <h5 class="card-title mb-4">Edit Jurusan</h5>

            <div class="container-fluid">
                <!-- Card form edit data jurusan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0">Form Edit Data Jurusan</h6>
                    </div>

                    <div class="card-body">
                        {{-- Form untuk mengirim data edit jurusan ke route jurusan.update --}}
                        <form action="{{ route('jurusan.update', $jurusan->id_jurusan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- ID Jurusan (hanya ditampilkan, tidak bisa diedit) --}}
                            <div class="mb-3">
                                <label for="id_jurusan" class="form-label">ID Jurusan</label>
                                <input type="number" name="id_jurusan" id="id_jurusan" class="form-control"
                                    value="{{ old('jurusan', $jurusan->jurusan) }}" disabled>
                            </div>

                            {{-- Kode Jurusan --}}
                            <div class="mb-3">
                                <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
                                <input type="text" name="kode_jurusan" id="kode_jurusan" class="form-control"
                                    value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required>
                            </div>

                            {{-- Nama Jurusan --}}
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Nama Jurusan</label>
                                <input type="text" name="jurusan" id="jurusan" class="form-control"
                                    value="{{ old('jurusan', $jurusan->jurusan) }}" required>
                            </div>

                            {{-- Tombol Simpan dan Batal --}}
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('jurusan') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
