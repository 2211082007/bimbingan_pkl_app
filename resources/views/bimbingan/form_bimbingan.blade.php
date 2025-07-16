@extends('layouts.master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h2>Tambah Kegiatan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('bimbinganPkl.store', ['id' => $data_usulanpkl->id_usulan]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- <input type="hidden" name="usulan_id" value="{{ $data_usulanpkl->id_usulan }}"> --}}

            <div class="form-group">
                <label for="tgl_awal">Tanggal Awal:</label>
                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tgl_akhir">Tanggal Akhir:</label>
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kegiatan">Kegiatan Selama Seminggu:</label>
                <textarea name="kegiatan" id="kegiatan" rows="3" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="laporan" class="form-label">Upload File</label>
                <input type="file" name="laporan" class="form-control" id="laporan" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
    </div>
    @endsection
