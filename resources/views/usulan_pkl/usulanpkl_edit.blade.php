@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Edit Usulan PKL</h5>
            <form action="{{ route('usulanpkl.update', $usulanpkl->id_usulan) }}" method="POST">
                @csrf
                @method('PUT')


                <div class="mb-3">
                    <label for="konfirmasi" class="form-label">Konfirmasi</label>
                    <select name="konfirmasi" id="konfirmasi" class="form-control" required>
                        <option value="belum" {{ old('konfirmasi', $usulanpkl->konfirmasi) == 'belum' ? 'selected' : '' }}>Belum</option>
                        <option value="sudah" {{ old('konfirmasi', $usulanpkl->konfirmasi) == 'sudah' ? 'selected' : '' }}>Sudah</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('usulanpkl') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@endsection
