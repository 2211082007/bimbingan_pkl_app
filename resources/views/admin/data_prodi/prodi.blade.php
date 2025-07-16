@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title" style="font-weight: bold;">Data Prodi</h3>
        <div class="mt-2">
            <a href="{{ route('prodi.create') }}" class="btn btn-primary">
                <i class="typcn typcn-plus"></i> Add New Prodi
            </a>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr class="table-success text-center">
                        <th>NO</th>
                        <th>Kode</th>
                        <th>Prodi</th>
                        <th>Jenjang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_prodi as $index => $data)
                        <tr>
                            <td class="text-center">{{ $index + 1 + ($data_prodi->currentPage() - 1) * $data_prodi->perPage() }}</td>
                            <td>{{ $data->kode_prodi }}</td>
                            <td>{{ $data->prodi }}</td>
                            <td>{{ $data->jenjang }}</td>
                            <td class="text-center">
                                <a href="{{ route('data_prodi.edit_prodi', $data->id_prodi) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('prodi.destroy', $data->id_prodi) }}" method="POST" style="display:inline-block;">
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

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $data_prodi->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
