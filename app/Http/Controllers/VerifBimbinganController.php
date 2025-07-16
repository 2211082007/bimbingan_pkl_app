<?php

namespace App\Http\Controllers;

use App\Models\BimbinganPKL;
use App\Models\Mahasiswa;
use App\Models\UsulanPKL;
use Illuminate\Http\Request;

class VerifBimbinganController extends Controller
{
    public function index(Request $request)
    {
        // Misalnya, ID pembimbing PKL yang sedang login atau dipilih
        $role = $request->query('role');
        $user = auth()->user();
        $dosen_id = $user->dosen->id_dosen; // Atau bisa ID lain yang relevan

        // Mengambil data bimbingan PKL yang hanya berisi mahasiswa yang dibimbing oleh pembimbing tertentu
        $data_belumVerif = BimbinganPKL::with('usulan_pkl.mahasiswa')
            ->where('verif', '0') // Belum diverifikasi
            ->whereHas('usulan_pkl', function ($query) use ($dosen_id) {
                $query->where('pembimbing_id', $dosen_id); // Filter berdasarkan pembimbing
            })
            ->get();

        $data_sudahVerif = BimbinganPKL::with('usulan_pkl.mahasiswa')
            ->where('verif', '!=', '0') // Sudah diverifikasi (1: Disetujui, 2: Ditolak)
            ->whereHas('usulan_pkl', function ($query) use ($dosen_id) {
                $query->where('pembimbing_id', $dosen_id); // Filter berdasarkan pembimbing
            })
            ->get();

        // Mengirimkan data ke view dengan dua variabel terpisah
        return view('bimbingan.verif_bimbingan', compact('role', 'data_belumVerif', 'data_sudahVerif'));
    }

    public function show($id)
    {
        // Ambil data usulan PKL dan semua data bimbingan terkait
        $data_mhs = Mahasiswa::where('id_mhs', $id)->get()->first();
        $data_usulanpkl = UsulanPKL::where('mhs_id', $id)->get()->first();
        $data_bimbinganPkl = BimbinganPkl::where('usulan_id', $id)->get()->first();

        $data_bimbinganPkl = BimbinganPkl::whereHas('usulan_pkl', function($query) use ($id) {
            $query->where('mhs_id', $id);
        })
        ->get();

        return view('bimbingan.detail_logbook', compact('data_mhs', 'data_usulanpkl', 'data_bimbinganPkl'));
    }

    public function verifikasiBimbingan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:255',
            'verif' => 'required|in:1,2', // 1: Disetujui, 2: Ditolak
        ]);

        $bimbingan = BimbinganPKL::findOrFail($id);

        $bimbingan->update([
            'verif' => $request->verif, // 1: Disetujui, 2: Ditolak
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('verif_bimbingan_pkl')
            ->with('success', 'Bimbingan berhasil diperbarui.');
    }

    public function batalVerifikasi($id)
    {
        $bimbingan = BimbinganPKL::findOrFail($id);
        $bimbingan->verif = '0'; // Set status verifikasi ke 0 (belum diverifikasi)
        $bimbingan->save();

        return redirect()->back()->with('success', 'Verifikasi berhasil dibatalkan.');
    }
}
