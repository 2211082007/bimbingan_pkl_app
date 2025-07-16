@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title mb-4">Edit Mahasiswa</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <form action="{{ route('mahasiswa.update', $mahasiswa->id_mhs) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- NIM -->
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" name="nim" id="nim" class="form-control"
                                        value="{{ old('nim', $mahasiswa->nim) }}" required>
                                </div>

                                <!-- Nama -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        value="{{ old('nama', $mahasiswa->nama) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{ old('email', $mahasiswa->email) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan_id" class="form-label">Jurusan</label>
                                    <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                                        <option selected disabled>Pilih Jurusan</option>
                                        @foreach($data_jurusan as $jurusan)
                                            <option value="{{ $jurusan->id_jurusan }}" {{ $mahasiswa->jurusan_id == $jurusan->id_jurusan ? 'selected' : '' }}>{{ $jurusan->jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Prodi -->
                                <div class="mb-3">
                                    <label for="prodi_id" class="form-label">Prodi</label>
                                    <select name="prodi_id" id="prodi_id" class="form-control" required>
                                        <option selected disabled>Pilih Program Studi</option>
                                        @foreach($data_prodi as $prodi)
                                            <option value="{{ $prodi->id_prodi }}" {{ $mahasiswa->prodi_id == $prodi->id_prodi ? 'selected' : '' }}>{{ $prodi->prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Jenis Kelamin -->
                                <div class="mb-3">
                                    <label class="form-label d-block">Jenis Kelamin</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_laki" value="laki-laki"
                                            {{ old('gender', $mahasiswa->gender) == 'laki-laki' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_laki">
                                            Laki-Laki
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_perempuan" value="perempuan"
                                            {{ old('gender', $mahasiswa->gender) == 'perempuan' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_perempuan">
                                            Perempuan
                                        </label>
                                    </div>
                                </div>


                                    <!-- Password -->
                                    {{-- <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                                </div> --}}

                                    <!-- Image -->
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload Gambar</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('mahasiswa') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            $('#prodi_id').empty();
                            $('#prodi_id').append(
                                '<option value="">Pilih Program Studi</option>');
                            $.each(data, function(key, value) {
                                $('#prodi_id').append('<option value="' + value
                                    .id_prodi + '">' + value.prodi +
                                    '</option>');
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
