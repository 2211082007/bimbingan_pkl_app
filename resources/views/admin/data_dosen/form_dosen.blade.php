@extends('layouts.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h2>Tambah Dosen</h2>

    {{-- Tampilkan pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form tambah dosen --}}
    <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Input ID Dosen --}}
        <div class="mb-3">
            <label for="id_dosen" class="form-label">ID Dosen</label>
            <input type="text" name="id_dosen" id="id_dosen" class="form-control" value="{{ old('id_dosen') }}" required>
        </div>

        {{-- Input NIDN --}}
        <div class="mb-3">
            <label for="nidn" class="form-label">NIDN</label>
            <input type="text" name="nidn" id="nidn" class="form-control" value="{{ old('nidn') }}" required>
        </div>

        {{-- Input NIP --}}
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip') }}" required>
        </div>

        {{-- Input Nama --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        {{-- Pilihan Jenis Kelamin --}}
        <div class="mb-3">
            <label for="gender" class="form-label">Jenis Kelamin</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender_laki" value="laki-laki" {{ old('gender') == 'laki-laki' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender_laki">Laki-Laki</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender_perempuan" value="perempuan" {{ old('gender') == 'perempuan' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender_perempuan">Perempuan</label>
            </div>
        </div>

        {{-- Tempat & Tanggal Lahir --}}
        <div class="mb-3">
            <label for="tempt_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" name="tempt_lahir" id="tempt_lahir" class="form-control" value="{{ old('tempt_lahir') }}" required>
        </div>

        <div class="mb-3">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}" required>
        </div>

        {{-- Pendidikan --}}
        <div class="mb-3">
            <label for="pendidikan" class="form-label">Pendidikan</label>
            <input type="text" name="pendidikan" id="pendidikan" class="form-control" value="{{ old('pendidikan') }}" required>
        </div>

        {{-- Pilihan Jurusan --}}
        <div class="mb-3">
            <label for="jurusan_id" class="form-label">Jurusan</label>
            <select name="jurusan_id" id="jurusan_id" class="form-control">
                <option value="">-- Pilih Jurusan --</option>
                @foreach ($data_jurusan as $jurusan)
                    <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->jurusan }}</option>
                @endforeach
            </select>
        </div>

        {{-- Pilihan Prodi (Akan berubah sesuai Jurusan yang dipilih) --}}
        <div class="mb-3">
            <label for="prodi_id" class="form-label">Prodi</label>
            <select name="prodi_id" id="prodi_id" class="form-control">
                <option value="">-- Pilih Prodi --</option>
                @foreach ($data_prodi as $prodi)
                    <option value="{{ $prodi->id_prodi }}">{{ $prodi->prodi }}</option>
                @endforeach
            </select>
        </div>

        {{-- Golongan --}}
        <div class="mb-3">
            <label for="golongan_id" class="form-label">Golongan</label>
            <select name="golongan_id" id="golongan_id" class="form-control" required>
                <option selected disabled>Pilih Golongan</option>
                @foreach ($data_golongan as $golongan)
                    <option value="{{ $golongan->id_golongan }}">{{ $golongan->golongan }}</option>
                @endforeach
            </select>
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat') }}">
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        {{-- Nomor HP --}}
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp') }}">
        </div>

        {{-- Upload Foto Dosen --}}
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- Status Aktif / Tidak --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

{{-- Script AJAX: Ambil Prodi berdasarkan Jurusan --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#jurusan_id').change(function() {
            var jurusanID = $(this).val();
            if (jurusanID) {
                $.ajax({
                    url: '/getProdi/' + jurusanID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#prodi_id').empty().append('<option value="">Pilih Program Studi</option>');
                        $.each(data, function(key, value) {
                            $('#prodi_id').append('<option value="' + value.id_prodi + '">' + value.prodi + '</option>');
                        });
                    }
                });
            } else {
                $('#prodi_id').empty().append('<option value="">Pilih Program Studi</option>');
            }
        });
    });
</script>

@endsection
