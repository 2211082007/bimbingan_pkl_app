@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2>Tambah Mahasiswa</h2>

        {{-- Validasi error ditampilkan jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form untuk menyimpan data mahasiswa --}}
        <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- Token keamanan Laravel --}}

            {{-- Input NIM --}}
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" value="{{ old('nim') }}" required>
            </div>

            {{-- Input Nama --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>

            {{-- Dropdown Jurusan --}}
            <div class="mb-3">
                <label for="jurusan_id" class="form-label">Jurusan</label>
                <select name="jurusan_id" id="jurusan_id" class="form-control">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach ($data_jurusan as $jurusan)
                        <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->jurusan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Dropdown Prodi yang akan diubah dinamis melalui Ajax --}}
            <div class="mb-3">
                <label for="prodi_id" class="form-label">Prodi</label>
                <select name="prodi_id" id="prodi_id" class="form-control">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($data_prodi as $prodi)
                        <option value="{{ $prodi->id_prodi }}">{{ $prodi->prodi }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Radio Button untuk Jenis Kelamin --}}
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender_laki" value="laki-laki"
                        {{ old('gender') == 'laki-laki' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gender_laki">Laki-Laki</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender_perempuan" value="perempuan"
                        {{ old('gender') == 'perempuan' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gender_perempuan">Perempuan</label>
                </div>
            </div>

            {{-- Input Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            {{-- Input Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            {{-- Upload Foto Mahasiswa --}}
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            {{-- Tombol Simpan --}}
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    {{-- Script Ajax untuk load prodi berdasarkan jurusan yang dipilih --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#jurusan_id').change(function() {
                var jurusanID = $(this).val();
                if (jurusanID) {
                    $.ajax({
                        url: '/getProdi/' + jurusanID, // Ambil prodi berdasarkan jurusan
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#prodi_id').empty(); // Kosongkan prodi sebelumnya
                            $('#prodi_id').append('<option value="">Pilih Program Studi</option>');
                            $.each(data, function(key, value) {
                                $('#prodi_id').append('<option value="' + value.id_prodi + '">' + value.prodi + '</option>');
                            });
                        }
                    });
                } else {
                    $('#prodi_id').empty();
                    $('#prodi_id').append('<option value="">Pilih Program Studi</option>');
                }
            });
        });
    </script>
@endsection
