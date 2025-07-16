<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\UsulanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsulanPklController extends Controller
{
    public function index()
{
    $mahasiswaId = auth()->user()->mahasiswa->id_mhs;
    $data_usulanpkl = UsulanPKL::with('mahasiswa', 'dosen')
    ->where('mhs_id', $mahasiswaId)
        ->get();

    return view('usulan_pkl.usulanpkl', compact('data_usulanpkl'));
}

    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        // $data_mahasiswa = DB::table('mahasiswa')->get();
        $data_dosen = Dosen::all();
        return view('usulan_pkl.form_usulanpkl', compact('mahasiswa','data_dosen'));
    }

    public function store(Request $request)
    {

        // Validation rules
        $validator = Validator::make($request->all(), [
            'mhs_id' => 'required',
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'upload_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'konfirmasi' => 'nullable|in:0,1',
        ]);

        // Redirect back if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Store the file and get the path
        $filename = '';
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName(); // Get the original filename
            $path = 'uploads/usulan_files/';
            $file->storeAs('public/' . $path, $filename); // Save file with the original name
        }

        // Prepare data for storing
        $data = [
            'mhs_id' => $request['mhs_id'],
            'nama_perusahaan' => $request->nama_perusahaan,
            'deskripsi' => $request->deskripsi,
            'upload_file' => $filename,
            'konfirmasi' => $request->konfirmasi ?? '0',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        UsulanPKL::create($data);

        $mahasiswa = Mahasiswa::find($request->mhs_id);

        if ($mahasiswa) {
            $user = User::where('email', $mahasiswa->email)->first();

            if ($user) {
                if (!$user->hasRole('mahasiswaPkl')) {
                    $user->assignRole('mahasiswaPkl');
                }
            }
        }

        // Redirect to the desired route with a success message
        return redirect()->route('usulanpkl')->with('success', 'Usulan PKL berhasil ditambahkan.');
    }


    public function verifikasi($id)
    {
        // Cari usulan berdasarkan ID
        $usulan = UsulanPKL::findOrFail($id);

        // Update kolom konfirmasi menjadi '1'
        $usulan->update(['konfirmasi' => '1']);

        // Redirect ke halaman dengan pesan sukses
        return redirect()->route('usulanpkl')
            ->with('success', 'Usulan PKL berhasil dikonfirmasi.');
    }


    public function destroy($id)
{
    // Cari usulan berdasarkan ID
    $usulan = UsulanPKL::findOrFail($id);

    // Periksa apakah usulan sudah terverifikasi
    if ($usulan->konfirmasi == 1) {
        return redirect()->route('usulanpkl')
            ->with('error', 'Usulan PKL yang sudah terverifikasi tidak bisa dihapus.');
    }

    // Jika belum terverifikasi, lakukan penghapusan
    $usulan->delete();

    return redirect()->route('usulanpkl')
        ->with('success', 'Usulan PKL berhasil dihapus.');
}

    // public function batalkanKonfirmasi($id)
    // {
    //     DB::table('usulan_pkl')
    //         ->where('id_usulan', $id)
    //         ->update(['konfirmasi' => '0']);

    //     return redirect()->route('usulanpkl')
    //         ->with('success', 'Konfirmasi usulan PKL berhasil dibatalkan.');
    // }

}



