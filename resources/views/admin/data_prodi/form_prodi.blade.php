@extends('layouts.master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h1>Tambah Prodi</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('prodi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_prodi" class="form-label">ID Prodi</label>
                <input type="number" name="id_prodi" id="id_prodi" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Kode Prodi</label>
                <input type="text" name="kode_prodi" id="kode_prodi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prodi" class="form-label">Nama Prodi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jurusan_id" class="form-label">Jurusan</label>
                <select name="jurusan_id" id="jurusan_id" class="form-control">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($data_jurusan as $jurusan)
                        <option value="{{ $jurusan->id_jurusan }}" {{ old('jurusan_id') == $jurusan->id_jurusan ? 'selected' : '' }}>
                            {{ $jurusan->jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jenjang" class="form-label">Jenjang</label>
                <select class="form-control" name="jenjang" id="jenjang" required>
                    <option value="">-- Pilih Jenjang--</option>
                    <option value="D3">D3</option>
                    <option value="D4">D4</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
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
