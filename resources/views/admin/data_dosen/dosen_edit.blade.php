@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title mb-4">Form Edit Dosen</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    {{-- <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0">Form Edit Data Dosen</h6>
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('dosen.update', $dosen->id_dosen) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- NIDN -->
                                <div class="mb-3">
                                    <label for="nidn" class="form-label">NIDN</label>
                                    <input type="text" name="nidn" id="nidn" class="form-control"
                                        value="{{ old('nidn', $dosen->nidn) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" name="nip" id="nip" class="form-control"
                                        value="{{ old('nip', $dosen->nip) }}" required>
                                </div>

                                <!-- Nama -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        value="{{ old('nama', $dosen->nama) }}" required>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_laki"
                                            value="laki-laki"
                                            {{ old('gender', $dosen->gender) == 'laki-laki' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_laki">
                                            Laki-Laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_perempuan"
                                            value="perempuan"
                                            {{ old('gender', $dosen->gender) == 'perempuan' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_perempuan">
                                            Perempuan
                                        </label>
                                    </div>

                                    <!-- Tempat Lahir -->
                                    <div class="mb-3">
                                        <label for="tempt_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" name="tempt_lahir" id="tempt_lahir" class="form-control"
                                            value="{{ old('tempt_lahir', $dosen->tempt_lahir) }}" required>
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div class="mb-3">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control"
                                            value="{{ old('tgl_lahir', $dosen->tgl_lahir) }}" required>
                                    </div>
                                    <!-- Password -->
                                    {{-- <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            value="{{ old('password') }}">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                                    </div> --}}
                                    <!-- Pendidikan -->
                                    <div class="mb-3">
                                        <label for="pendidikan" class="form-label">Pendidikan</label>
                                        <input type="text" name="pendidikan" id="pendidikan" class="form-control"
                                            value="{{ old('pendidikan', $dosen->pendidikan) }}" required>
                                    </div>

                                    <!-- Jurusan -->
                                    <div class="form-group">
                                        <label for="jurusan_id">Jurusan</label>
                                        <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                                            <option value="">-- Pilih Jurusan --</option>
                                            @foreach ($data_jurusan as $jurusan)
                                                <option value="{{ $jurusan->id_jurusan }}"
                                                    {{ old('jurusan_id', $dosen->jurusan_id) == $jurusan->id_jurusan ? 'selected' : '' }}>
                                                    {{ $jurusan->jurusan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Prodi -->
                                     <div class="mb-3">
                                        <label for="prodi_id">Prodi</label>
                                        <select name="prodi_id" id="prodi_id" class="form-control" required>
                                            <option value="">-- Pilih Prodi --</option>
                                            @foreach ($data_prodi as $prodi)
                                                <option value="{{ $prodi->id_prodi }}"
                                                    {{ old('prodi_id', $dosen->prodi_id) == $prodi->id_prodi ? 'selected' : '' }}>
                                                    {{ $prodi->prodi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Alamat -->
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" name="alamat" id="alamat" class="form-control"
                                            value="{{ old('alamat', $dosen->alamat) }}" required>
                                    </div>

                                    <!-- Email -->
                                    {{-- <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ old('email', $dosen->email) }}" required>
                                    </div> --}}

                                    <!-- No HP -->
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="text" name="no_hp" id="no_hp" class="form-control"
                                            value="{{ old('no_hp', $dosen->no_hp) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="golongan_id">Golongan</label>
                                        <select name="golongan_id" id="golongan_id" class="form-control" required>
                                            <option value="">-- Pilih Golongan --</option>
                                            @foreach ($data_golongan as $golongan)
                                                <option value="{{ $golongan->id_golongan }}"
                                                    {{ old('golongan_id', $dosen->golongan_id) == $golongan->id_golongan ? 'selected' : '' }}>
                                                    {{ $golongan->golongan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Status -->
                                    <div class="form-group mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $dosen->status == 1 ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="0" {{ $dosen->status == 0 ? 'selected' : '' }}>Tidak Aktif
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('dosen') }}" class="btn btn-secondary">Batal</a>
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
