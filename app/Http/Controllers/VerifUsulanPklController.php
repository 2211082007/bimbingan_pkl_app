<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\PimpinanProdi;
use App\Models\User;
use App\Models\UsulanPKL;
use Illuminate\Http\Request;

class VerifUsulanPklController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $prodiIds = PimpinanProdi::where('dosen_id', optional($user->dosen)->id_dosen)
        ->pluck('prodi_id')
        ->toArray();

    // Ambil data berdasarkan status konfirmasi
    $belumDikonfirmasi = UsulanPKL::with(['mahasiswa', 'dosen'])
        ->where('konfirmasi', '0')
        ->whereHas('mahasiswa.prodi', function ($query) use ($prodiIds) {
            $query->whereIn('id_prodi', $prodiIds);
        })
        ->get();

    $sudahDikonfirmasi = UsulanPKL::with(['mahasiswa', 'dosen'])
        ->where('konfirmasi', '1')
        ->whereHas('mahasiswa.prodi', function ($query) use ($prodiIds) {
            $query->whereIn('id_prodi', $prodiIds);
        })
        ->get();

    $dosenList = Dosen::all();

    return view('verif_usulan.verif_usulan_pkl', compact('belumDikonfirmasi', 'sudahDikonfirmasi', 'dosenList'));
}

    /**
     * Memperbarui status konfirmasi dan menambahkan dosen pembimbing.
     */
    public function konfirmasi(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'pembimbing_id' => 'required|exists:dosen,id_dosen',
        ]);

        // Cari usulan berdasarkan ID
        $usulan = UsulanPKL::findOrFail($id);

        // Update status konfirmasi dan pembimbing
        $usulan->update([
            'konfirmasi' => '1', // Atur menjadi sudah diverifikasi
            'pembimbing_id' => $request->pembimbing_id,
        ]);

        $dosen = Dosen::find($request->pembimbing_id);

        if ($dosen) {
            $user = User::where('email', $dosen->email)->first();

            if ($user) {
                if (!$user->hasRole('pembimbingPkl')) {
                    $user->assignRole('pembimbingPkl');
                }
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route('verif_usulan_pkl')
            ->with('success', 'Usulan PKL berhasil diverifikasi dan dosen pembimbing ditambahkan.');
    }

    public function batalkan($id)
    {
        // Cari usulan berdasarkan ID
        $usulan = UsulanPKL::findOrFail($id);

        try {
            $usulan->update([
                'konfirmasi' => '0',
                'pembimbing_id' => null, // Opsi: Hapus pembimbing jika verifikasi dibatalkan
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        try {
            $dosen = Dosen::find($id);

            if ($dosen) {
                $user = User::where('email', $dosen->email)->first();

                if ($user) {
                    if (!$user->hasRole('pembimbingPkl')) {
                        $user->removeRole('pembimbingPkl');
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }


        // Redirect kembali dengan pesan sukses
        return redirect()->route('verif_usulan_pkl')
            ->with('success', 'Verifikasi berhasil dibatalkan.');
    }
}
