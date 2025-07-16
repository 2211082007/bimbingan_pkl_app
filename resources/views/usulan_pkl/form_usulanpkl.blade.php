@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Tambah Usulan PKL</h5>

            <!-- Menampilkan pesan error jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usulanpkl.store') }}" method="POST" enctype="multipart/form-data">
                @csrf


<input type="hidden" name="mhs_id" value="{{$mahasiswa->id_mhs}}">

                <!-- Nama Perusahaan -->
                <div class="mb-3">
                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                </div>

                <!-- Upload File -->
                <div class="mb-3">
                    <label for="upload_file" class="form-label">Upload File</label>
                    <input type="file" name="upload_file" class="form-control" id="upload_file" accept=".pdf,.doc,.docx">
                </div>

                <!-- Tombol Aksi -->
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('usulanpkl') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@endsection
