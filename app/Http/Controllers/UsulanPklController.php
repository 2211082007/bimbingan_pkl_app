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

/**
 * Controller untuk mengelola usulan PKL mahasiswa:
 * - Menampilkan, membuat, memverifikasi, dan menghapus usulan PKL.
 */
class UsulanPklController extends Controller
{
    /**
     * Menampilkan daftar usulan PKL milik mahasiswa yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $mahasiswaId = auth()->user()->mahasiswa->id_mhs;

        $data_usulanpkl = UsulanPKL::with('mahasiswa', 'dosen')
            ->where('mhs_id', $mahasiswaId)
            ->get();

        return view('usulan_pkl.usulanpkl', compact('data_usulanpkl'));
    }

    /**
     * Menampilkan form untuk mengajukan usulan PKL baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $data_dosen = Dosen::all();

        return view('usulan_pkl.form_usulanpkl', compact('mahasiswa', 'data_dosen'));
    }

    /**
     * Menyimpan data usulan PKL baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'mhs_id' => 'required',
            'nama_perusahaan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'upload_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'konfirmasi' => 'nullable|in:0,1',
        ]);

        // Jika validasi gagal, kembalikan ke form
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Proses upload file jika ada
        $filename = '';
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $filename = $file->getClientOriginalName();
            $path = 'uploads/usulan_files/';
            $file->storeAs('public/' . $path, $filename);
        }

        // Data yang akan disimpan
        $data = [
            'mhs_id' => $request['mhs_id'],
            'nama_perusahaan' => $request->nama_perusahaan,
            'deskripsi' => $request->deskripsi,
            'upload_file' => $filename,
            'konfirmasi' => $request->konfirmasi ?? '0',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Simpan ke database
        UsulanPKL::create($data);

        // Tambahkan role "mahasiswaPkl" jika belum ada
        $mahasiswa = Mahasiswa::find($request->mhs_id);
        if ($mahasiswa) {
            $user = User::where('email', $mahasiswa->email)->first();
            if ($user && !$user->hasRole('mahasiswaPkl')) {
                $user->assignRole('mahasiswaPkl');
            }
        }

        return redirect()->route('usulanpkl')->with('success', 'Usulan PKL berhasil ditambahkan.');
    }

    /**
     * Verifikasi usulan PKL (set konfirmasi menjadi 1).
     *
     * @param int $id ID usulan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifikasi($id)
    {
        $usulan = UsulanPKL::findOrFail($id);
        $usulan->update(['konfirmasi' => '1']);

        return redirect()->route('usulanpkl')
            ->with('success', 'Usulan PKL berhasil dikonfirmasi.');
    }

    /**
     * Menghapus usulan PKL (jika belum diverifikasi).
     *
     * @param int $id ID usulan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $usulan = UsulanPKL::findOrFail($id);

        // Tidak bisa dihapus jika sudah diverifikasi
        if ($usulan->konfirmasi == 1) {
            return redirect()->route('usulanpkl')
                ->with('error', 'Usulan PKL yang sudah terverifikasi tidak bisa dihapus.');
        }

        $usulan->delete();

        return redirect()->route('usulanpkl')
            ->with('success', 'Usulan PKL berhasil dihapus.');
    }

    // OPTIONAL FEATURE:
    // /**
    //  * Membatalkan verifikasi usulan PKL (set konfirmasi ke 0).
    //  *
    //  * @param int $id
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function batalkanKonfirmasi($id)
    // {
    //     DB::table('usulan_pkl')
    //         ->where('id_usulan', $id)
    //         ->update(['konfirmasi' => '0']);
    //
    //     return redirect()->route('usulanpkl')
    //         ->with('success', 'Konfirmasi usulan PKL berhasil dibatalkan.');
    // }
}
