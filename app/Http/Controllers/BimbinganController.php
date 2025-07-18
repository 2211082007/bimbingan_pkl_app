<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\UsulanPKL;
use App\Models\BimbinganPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    /**
     * Menampilkan data usulan PKL yang sudah dikonfirmasi,
     * baik untuk dosen pembimbing maupun mahasiswa.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $role = $request->query('role');
        $user = auth()->user();

        // Ambil ID dosen atau mahasiswa tergantung role
        $dosen_id = optional($user->dosen)->id_dosen;
        $mhs_id = optional($user->mahasiswa)->id_mhs;

        // Ambil data usulan PKL yang dibimbing oleh dosen
        $pkl_pembimbing = UsulanPKL::with(['mahasiswa', 'mahasiswa.prodi'])
            ->when($dosen_id, function ($query) use ($dosen_id) {
                $query->where('pembimbing_id', $dosen_id);
            })
            ->where('konfirmasi', '1') // Hanya yang sudah dikonfirmasi
            ->get();

        // Ambil data usulan PKL milik mahasiswa
        $pkl_mahasiswa = UsulanPKL::with(['mahasiswa', 'mahasiswa.prodi'])
            ->when($mhs_id, function ($query) use ($mhs_id) {
                $query->where('mhs_id', $mhs_id);
            })
            ->where('konfirmasi', '1')
            ->get();

        return view('bimbingan.bimbingan_pkl', compact('pkl_pembimbing', 'pkl_mahasiswa', 'role'));
    }

    /**
     * Menampilkan detail logbook bimbingan dari seorang mahasiswa.
     *
     * @param int $id ID Mahasiswa
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data_mhs = Mahasiswa::where('id_mhs', $id)->first();
        $data_usulanpkl = UsulanPKL::where('mhs_id', $data_mhs->id_mhs)->first();
        $data_bimbinganPkl = BimbinganPkl::where('usulan_id', $data_usulanpkl->id_usulan)->get();

        return view('bimbingan.detail_logbook', compact('data_mhs', 'data_usulanpkl', 'data_bimbinganPkl'));
    }

    /**
     * Menyimpan data logbook bimbingan baru ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'kegiatan' => 'required|string',
            'laporan' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Proses upload file
        if ($request->hasFile('laporan')) {
            $file = $request->file('laporan');
            $path = $file->store('bimbingan_files', 'public');
            $validatedData['laporan'] = $path;
        }

        $mhs = Mahasiswa::where('email', Auth::user()->email)->first();

        // Simpan ke tabel bimbingan_pkl
        BimbinganPkl::create([
            'usulan_id' => $request->id,
            'tgl_awal' => $validatedData['tgl_awal'],
            'tgl_akhir' => $validatedData['tgl_akhir'],
            'kegiatan' => $validatedData['kegiatan'],
            'laporan' => $validatedData['laporan'],
        ]);

        return redirect()->route('logbook.view', ['id' => $mhs->id_mhs])
            ->with('success', 'Logbook entry successfully added.');
    }
}
