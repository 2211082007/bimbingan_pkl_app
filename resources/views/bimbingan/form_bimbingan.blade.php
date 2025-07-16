@extends('layouts.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Tambah Kegiatan PKL</h4>
        </div>

        <div class="card-body">
            {{-- Error message --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('bimbinganPkl.store', ['id' => $data_usulanpkl->id_usulan]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="tgl_awal">Tanggal Awal:</label>
                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="tgl_akhir">Tanggal Akhir:</label>
                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="kegiatan">Kegiatan Selama Seminggu:</label>
                    <textarea name="kegiatan" id="kegiatan" rows="3" class="form-control" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="laporan" class="form-label">Upload File</label>
                    <input type="file" name="laporan" class="form-control" id="laporan" accept=".pdf,.doc,.docx">
                </div>

                <div class="form-group text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
