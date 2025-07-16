@extends('layouts.master')

@section('content')

    @hasrole('admin')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title" style="font-weight: bold; color: #007bff;">Data Usulan PKL (Admin)</h3>
            <div class="mt-2 mb-2">
                <a href="{{ route('usulanpkl.create') }}" class="btn btn-primary">
                    <i class="typcn typcn-plus"></i> Add New Tempat PKL
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat Perusahaan</th>
                            <th>Upload File</th>
                            <th>Konfirmasi</th>
                            <th>Pembimbing</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_usulanpkl as $index => $data)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $data->mahasiswa->nama }}</td>
                                <td>{{ $data->nama_perusahaan }}</td>
                                <td>{{ $data->deskripsi }}</td>
                                <td>
                                    @if ($data->upload_file)
                                        <a href="{{ asset('storage/uploads/usulan_files/' . $data->upload_file) }}" target="_blank">
                                            <i class="fas fa-file-pdf"></i> Lihat File
                                        </a>
                                    @else
                                        <span class="text-muted"><i class="fas fa-times-circle"></i> File tidak tersedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($data->konfirmasi == '1')
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Sudah Dikonfirmasi</span>
                                    @else
                                        <span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> Belum</span>
                                    @endif
                                </td>
                                <td>{{ $data->pembimbing_id ? $data->dosen->nama : 'Belum ada pembimbing' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('usulanpkl.destroy', $data->id_usulan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin untuk membatalkan?')">
                                            <i class="fas fa-trash"></i> Batal
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
    @endhasrole

    @hasanyrole('mahasiswaPkl|mahasiswa')
        <div class="card">
            <div class="card-body">
                {{-- {{ $data_usulan->mahasiswa->nama }} --}}
                    <h2 class="card-title" style="font-weight: bold; color: black;">Data Usulan PKL </h2>

                    <div class="mt-2 mb-2">
                        <a href="{{ route('usulanpkl.create') }}" class="btn btn-primary">
                            <i class="typcn typcn-plus"></i> Ajukan Tempat PKL
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Data lainnya dalam tabel -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            @foreach ($data_usulanpkl as $data)
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <td>{{ $data->mahasiswa->nama }}</td>
                            </tr>
                            <tr>
                                <th>Prodi Mahasiswa</th>
                                <td>{{ $data->mahasiswa->prodi->prodi }}</td>
                            </tr>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <td>{{ $data->nama_perusahaan }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Perusahaan</th>
                                <td>{{ $data->deskripsi }}</td>
                            </tr>
                            <tr>
                                <th>Upload File</th>
                                <td>
                                    @if ($data->upload_file)
                                        <a href="{{ asset('storage/uploads/usulan_files/' . $data->upload_file) }}" target="_blank">
                                            <i class="fas fa-file-pdf"></i> Lihat File
                                        </a>
                                    @else
                                        <span class="text-muted"><i class="fas fa-times-circle"></i> File tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($data->konfirmasi == '1')
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Sudah Dikonfirmasi</span>
                                    @else
                                        <span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> Belum</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td class="action-btns">
                                    <form action="{{ route('usulanpkl.destroy', $data->id_usulan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin untuk membatalkan usulan ini?')">
                                            <i class="fas fa-trash"></i> Batal
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr> <!-- Pembatas antar data usulan -->
                @endforeach
            </div>
        </div>

    @endhasanyrole
@endsection
