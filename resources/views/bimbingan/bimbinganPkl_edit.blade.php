@extends('layouts.master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2>Edit Kegiatan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form for editing logbook entry -->
        <form action="{{ route('bimbinganPkl.update', $data_bimbinganPkl->id_bimbinganPkl) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="usulan_id">Usulan PKL:</label>
                <select name="usulan_id" id="usulan_id" class="form-control" required>
                    @foreach($data_usulanpkl as $usulan)
                        <option value="{{ $usulan->id_usulan }}" {{ $usulan->id_usulan == $data_bimbinganPkl->usulan_id ? 'selected' : '' }}>
                            {{ $usulan->nama_perusahaan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tgl_awal">Tanggal Awal:</label>
                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="{{ $data_bimbinganPkl->tgl_awal }}" required>
            </div>

            <div class="form-group">
                <label for="tgl_akhir">Tanggal Akhir:</label>
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ $data_bimbinganPkl->tgl_akhir }}" required>
            </div>

            <div class="form-group">
                <label for="kegiatan">Kegiatan Selama Seminggu:</label>
                <textarea name="kegiatan" id="kegiatan" rows="3" class="form-control" required>{{ $data_bimbinganPkl->kegiatan }}</textarea>
            </div>

            <div class="form-group">
                <label for="laporan" class="form-label">Upload File</label>
                <input type="file" name="laporan" class="form-control" id="laporan" accept=".pdf,.doc,.docx">
                @if ($data_bimbinganPkl->laporan)
                    <p>File Saat Ini: <a href="{{ Storage::url($data_bimbinganPkl->laporan) }}" target="_blank">Lihat Laporan</a></p>
                @endif
            </div>

            {{-- <div class="form-group">
                <label for="catatan">Catatan:</label>
                <textarea name="catatan" id="catatan" rows="3" class="form-control">{{ $data_bimbinganPkl->catatan }}</textarea>
            </div>

            <div class="form-group">
                <label for="verif">Status Verifikasi:</label>
                <select name="verif" id="verif" class="form-control" required>
                    <option value="0" {{ $data_bimbinganPkl->verif == '0' ? 'selected' : '' }}>Belum Terverifikasi</option>
                    <option value="1" {{ $data_bimbinganPkl->verif == '1' ? 'selected' : '' }}>Terverifikasi</option>
                </select>
            </div> --}}

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
