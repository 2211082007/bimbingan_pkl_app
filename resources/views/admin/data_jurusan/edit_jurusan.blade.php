@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title mb-4">Edit Jurusan</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0">Form Edit Data Jurusan</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('jurusan.update', $jurusan->id_jurusan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="id_jurusan" class="form-label">ID Jurusan</label>
                                    <input type="number" name="id_jurusan" id="id_jurusan" class="form-control"
                                    value="{{ old('jurusan', $jurusan->jurusan) }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="kode_jurusan" class="form-label">Jurusan</label>
                                    <input type="text" name="kode_jurusan" id="kode_jurusan" class="form-control"
                                        value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required>
                                </div>
                                <!-- jurusan -->
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" name="jurusan" id="jurusan" class="form-control"
                                        value="{{ old('jurusan', $jurusan->jurusan) }}" required>
                                </div>


                                <!-- Submit Button -->
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
