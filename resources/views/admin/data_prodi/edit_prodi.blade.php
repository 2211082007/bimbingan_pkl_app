@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title mb-1">Edit Prodi</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    {{-- <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0">Form Edit Data</h6>
                        </div> --}}
                    <div class="card-body">
                        <form action="{{ route('prodi.update', $prodi->id_prodi) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="kode_prodi" class="form-label">Kode Prodi</label>
                                <input type="text" name="kode_prodi" id="kode_prodi" class="form-control"
                                    value="{{ old('kode_prodi', $prodi->kode_prodi) }}" required>
                            </div>
                            <!-- Prodi -->
                            <div class="mb-3">
                                <label for="prodi" class="form-label">Prodi</label>
                                <input type="text" name="prodi" id="prodi" class="form-control"
                                    value="{{ old('prodi', $prodi->prodi) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <select name="jurusan_id" id="jurusan_id" class="form-control">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($data_jurusan as $jurusan)
                                        <option value="{{ $jurusan->id_jurusan }}"
                                            {{ old('jurusan_id', $prodi->jurusan_id) == $jurusan->id_jurusan ? 'selected' : '' }}>
                                            {{ $jurusan->jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Jenjang -->
                            <div class="form-group mb-3">
                                <label for="jenjang">Pilih Jenjang:</label>
                                <select name="jenjang" id="jenjang" class="form-control">
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="D3" {{ old('jenjang', $prodi->jenjang) == 'D3' ? 'selected' : '' }}>
                                        D3</option>
                                    <option value="D4" {{ old('jenjang', $prodi->jenjang) == 'D4' ? 'selected' : '' }}>
                                        D4</option>
                                </select>
                                @error('jenjang')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('prodi') }}" class="btn btn-secondary">Batal</a>
                            </div>

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
