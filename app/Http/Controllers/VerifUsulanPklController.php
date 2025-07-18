<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\PimpinanProdi;
use App\Models\User;
use App\Models\UsulanPKL;
use Illuminate\Http\Request;

/**
 * Controller untuk proses verifikasi usulan PKL oleh pimpinan prodi:
 * - Menampilkan usulan yang belum dan sudah diverifikasi
 * - Menetapkan dosen pembimbing
 * - Membatalkan verifikasi
 */
class VerifUsulanPklController extends Controller
{
    /**
     * Menampilkan daftar usulan PKL yang belum dan sudah dikonfirmasi
     * berdasarkan prodi yang dipimpin oleh user saat ini.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        // Ambil semua ID prodi yang dipimpin oleh dosen yang login
        $prodiIds = PimpinanProdi::where('dosen_id', optional($user->dosen)->id_dosen)
            ->pluck('prodi_id')
            ->toArray();

        // Usulan belum dikonfirmasi (konfirmasi = 0)
        $belumDikonfirmasi = UsulanPKL::with(['mahasiswa', 'dosen'])
            ->where('konfirmasi', '0')
            ->whereHas('mahasiswa.prodi', function ($query) use ($prodiIds) {
                $query->whereIn('id_prodi', $prodiIds);
            })
            ->get();

        // Usulan sudah dikonfirmasi (konfirmasi = 1)
        $sudahDikonfirmasi = UsulanPKL::with(['mahasiswa', 'dosen'])
            ->where('konfirmasi', '1')
            ->whereHas('mahasiswa.prodi', function ($query) use ($prodiIds) {
                $query->whereIn('id_prodi', $prodiIds);
            })
            ->get();

        $dosenList = Dosen::all(); // Untuk dropdown pemilihan pembimbing

        return view('verif_usulan.verif_usulan_pkl', compact('belumDikonfirmasi', 'sudahDikonfirmasi', 'dosenList'));
    }

    /**
     * Menyetujui/verifikasi usulan PKL dan menetapkan dosen pembimbing.
     *
     * @param Request $request
     * @param int $id ID usulan PKL
     * @return \Illuminate\Http\RedirectResponse
     */
    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'pembimbing_id' => 'required|exists:dosen,id_dosen',
        ]);

        $usulan = UsulanPKL::findOrFail($id);

        // Set usulan menjadi terverifikasi dan simpan pembimbing
        $usulan->update([
            'konfirmasi' => '1',
            'pembimbing_id' => $request->pembimbing_id,
        ]);

        // Tambahkan role pembimbingPkl ke user jika belum ada
        $dosen = Dosen::find($request->pembimbing_id);
        if ($dosen) {
            $user = User::where('email', $dosen->email)->first();
            if ($user && !$user->hasRole('pembimbingPkl')) {
                $user->assignRole('pembimbingPkl');
            }
        }

        return redirect()->route('verif_usulan_pkl')
            ->with('success', 'Usulan PKL berhasil diverifikasi dan dosen pembimbing ditambahkan.');
    }

    /**
     * Membatalkan verifikasi usulan PKL dan menghapus pembimbing yang ditetapkan.
     *
     * @param int $id ID usulan PKL
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batalkan($id)
    {
        $usulan = UsulanPKL::findOrFail($id);

        try {
            // Batalkan status verifikasi dan hapus pembimbing
            $usulan->update([
                'konfirmasi' => '0',
                'pembimbing_id' => null,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        try {
            // OPTIONAL: Jika ingin menghapus role pembimbing dari user dosen
            $dosenId = $usulan->pembimbing_id;
            $dosen = Dosen::find($dosenId);
            if ($dosen) {
                $user = User::where('email', $dosen->email)->first();
                if ($user && $user->hasRole('pembimbingPkl')) {
                    $user->removeRole('pembimbingPkl');
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->route('verif_usulan_pkl')
            ->with('success', 'Verifikasi berhasil dibatalkan.');
    }
}
