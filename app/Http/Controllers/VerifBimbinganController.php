<?php

namespace App\Http\Controllers;

use App\Models\BimbinganPKL;
use App\Models\Mahasiswa;
use App\Models\UsulanPKL;
use Illuminate\Http\Request;

/**
 * Controller untuk verifikasi bimbingan PKL:
 * - Menampilkan daftar bimbingan
 * - Melakukan verifikasi oleh dosen pembimbing
 * - Melihat detail logbook
 * - Membatalkan verifikasi
 */
class VerifBimbinganController extends Controller
{
    /**
     * Menampilkan daftar bimbingan PKL berdasarkan status verifikasi
     * untuk dosen pembimbing yang sedang login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $role = $request->query('role');
        $user = auth()->user();
        $dosen_id = $user->dosen->id_dosen;

        // Ambil bimbingan yang belum diverifikasi
        $data_belumVerif = BimbinganPKL::with('usulan_pkl.mahasiswa')
            ->where('verif', '0')
            ->whereHas('usulan_pkl', function ($query) use ($dosen_id) {
                $query->where('pembimbing_id', $dosen_id);
            })
            ->get();

        // Ambil bimbingan yang sudah diverifikasi (1 = disetujui, 2 = ditolak)
        $data_sudahVerif = BimbinganPKL::with('usulan_pkl.mahasiswa')
            ->where('verif', '!=', '0')
            ->whereHas('usulan_pkl', function ($query) use ($dosen_id) {
                $query->where('pembimbing_id', $dosen_id);
            })
            ->get();

        return view('bimbingan.verif_bimbingan', compact('role', 'data_belumVerif', 'data_sudahVerif'));
    }

    /**
     * Menampilkan detail logbook bimbingan dari mahasiswa tertentu.
     *
     * @param int $id ID mahasiswa
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data_mhs = Mahasiswa::where('id_mhs', $id)->first();
        $data_usulanpkl = UsulanPKL::where('mhs_id', $id)->first();

        // Ambil semua bimbingan berdasarkan mahasiswa (melalui relasi usulan)
        $data_bimbinganPkl = BimbinganPKL::whereHas('usulan_pkl', function ($query) use ($id) {
            $query->where('mhs_id', $id);
        })->get();

        return view('bimbingan.detail_logbook', compact('data_mhs', 'data_usulanpkl', 'data_bimbinganPkl'));
    }

    /**
     * Menyimpan hasil verifikasi dari dosen pembimbing terhadap logbook bimbingan.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID bimbingan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifikasiBimbingan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:255',
            'verif' => 'required|in:1,2', // 1 = Disetujui, 2 = Ditolak
        ]);

        $bimbingan = BimbinganPKL::findOrFail($id);

        $bimbingan->update([
            'verif' => $request->verif,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('verif_bimbingan_pkl')
            ->with('success', 'Bimbingan berhasil diperbarui.');
    }

    /**
     * Membatalkan verifikasi terhadap logbook (mengembalikan ke status belum diverifikasi).
     *
     * @param int $id ID bimbingan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batalVerifikasi($id)
    {
        $bimbingan = BimbinganPKL::findOrFail($id);
        $bimbingan->verif = '0'; // Set ulang ke status belum diverifikasi
        $bimbingan->save();

        return redirect()->back()->with('success', 'Verifikasi berhasil dibatalkan.');
    }
}
