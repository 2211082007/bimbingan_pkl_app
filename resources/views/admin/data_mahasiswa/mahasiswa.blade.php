@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title" style="font-weight: bold;">Data Mahasiswa</h3>
        <div class="mt-2">
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                <i class="typcn typcn-mortar-board"></i> Add New Mahasiswa
            </a>
            <a href="{{ route('mahasiswa.export') }}" class="btn btn-success">
                <i class="typcn typcn-download"></i> Export
            </a>
            <a href="{{ route('mahasiswa.import') }}" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#import">
                <i class="typcn typcn-upload"></i> Import
            </a>

            {{-- Modal Import --}}
            <div class="modal fade" id="import" tabindex="-1" aria-labelledby="importLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importLabel">Import Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('mahasiswa.import') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="col-form-label">Import File</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                    @error('file')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-info">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr class="table-success text-center">
                        <th>NO</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_mahasiswa as $index => $data)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $data->nim }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->jurusan }}</td>
                        <td>{{ $data->prodi }}</td>
                        <td>{{ $data->gender }}</td>
                        <td class="text-center">
                            <a href="{{ route('mahasiswa.show', $data->id_mhs) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('data_mahasiswa.mahasiswa_edit', $data->id_mhs) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('mahasiswa.destroy', $data->id_mhs) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin untuk menghapus?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
