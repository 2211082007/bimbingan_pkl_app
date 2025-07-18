@extends('layouts.master')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $role = $user->getRoleNames()->first();
    $data = null;

    if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswaPkl')) {
        $data = $user->mahasiswa;
    } elseif ($user->hasRole('dosen') || $user->hasRole('kaprodi') || $user->hasRole('pembimbingPkl')) {
        $data = $user->dosen;
    }
@endphp

{{-- DASHBOARD ADMIN --}}
@hasrole('admin')
<div class="row">
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h4>Jumlah Mahasiswa</h4>
                <h2>{{ $jumlahMahasiswa }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h4>Jumlah Dosen</h4>
                <h2>{{ $jumlahDosen }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h4>Jumlah Prodi</h4>
                <h2>{{ $jumlahProdi }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h4>Jumlah Jurusan</h4>
                <h2>{{ $jumlahJurusan }}</h2>
            </div>
        </div>
    </div>
</div>
@endhasrole

{{-- FORM EDIT UNTUK MAHASISWA / DOSEN --}}
@hasanyrole('mahasiswa|mahasiswaPkl|dosen|kaprodi|pembimbingPkl')
@if ($data)
<div class="row">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <img src="{{ asset('storage/' . ($data->image ?? 'default.jpg')) }}" width="100" class="rounded-circle mb-2"
                     onerror="this.src='{{ asset('assets/images/default.jpg') }}'">
                <h4>{{ $data->nama }}</h4>
                <p>{{ $data->jurusan->jurusan ?? '-' }}</p>
                <p>{{ $data->prodi->prodi ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4>Edit Akun</h4>
                <form method="POST" action="{{ route('updateAkun') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- NIM/NIP --}}
                    <div class="mb-3">
                        <label>NIM / NIP</label>
                        <input type="text" class="form-control" value="{{ $data->nim ?? $data->nip }}" readonly>
                    </div>

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control"
                               value="{{ old('nama', $data->nama) }}">
                    </div>

                    {{-- JURUSAN --}}
                    <div class="mb-3">
                        <label>Jurusan</label>
                        <input type="text" class="form-control"
                               value="{{ $data->jurusan->jurusan ?? '-' }}" readonly>
                    </div>

                    {{-- PRODI --}}
                    <div class="mb-3">
                        <label>Prodi</label>
                        <input type="text" class="form-control"
                               value="{{ $data->prodi->prodi ?? '-' }}" readonly>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="">
                    </div>

                    {{-- IMAGE --}}
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endhasanyrole
@endsection
