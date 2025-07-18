@extends('layouts.master')

@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title" style="font-weight: bold;">Data Dosen</h3>

        <!-- Tombol Aksi: Tambah, Export, Import -->
        <div class="mt-2">
            <a href="{{ route('dosen.create') }}" class="btn btn-primary">
                <i class="typcn typcn-mortar-board"></i> Add New Dosen
            </a>
            <a href="{{ route('dosen.export') }}" class="btn btn-success">
                <i class="typcn typcn-download"></i> Export
            </a>
            <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#import">
                <i class="typcn typcn-upload"></i> Import
            </a>

            <!-- Modal Import File Excel -->
            <div class="modal fade" id="import" tabindex="-1" aria-labelledby="importLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="importlabel">Import Data Dosen</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form method="post" action="{{ route('dosen.import') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="col-form-label">Import File</label>
                                    <input type="file" class="form-control" name="file" id="file">
                                    @error('file')
                                        <small>{{ $message }}</small>
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

        <!-- Tabel Data Dosen -->
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr class="table-success text-center">
                        <th>NO</th>
                        <th>NIDN</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Pendidikan</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_dosen as $index => $data)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $data->nidn }}</td>
                            <td>{{ $data->nip }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->gender }}</td>
                            <td>{{ $data->pendidikan }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->email }}</td>
                            <td class="text-center">
                                {{ $data->status == 0 ? 'Tidak Aktif' : 'Aktif' }}
                            </td>
                            <td class="text-center">
                                <!-- Tombol Detail -->
                                <a href="{{ route('dosen.show', $data->id_dosen) }}" class="btn btn-info btn-sm">Detail</a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('data_dosen.dosen_edit', $data->id_dosen) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Tombol Delete -->
                                <form action="{{ route('dosen.destroy', $data->id_dosen) }}" method="POST" style="display:inline;">
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
