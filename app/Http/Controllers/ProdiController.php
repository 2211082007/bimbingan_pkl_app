<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller untuk mengelola data Program Studi (Prodi):
 * - Menampilkan, menambah, mengedit, dan menghapus prodi.
 * - Mengatur relasi dengan jurusan.
 */
class ProdiController extends Controller
{
    /**
     * Menampilkan daftar seluruh prodi dengan relasi jurusan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data_prodi = DB::table('prodi')
            ->join('jurusan', 'prodi.jurusan_id', '=', 'jurusan.id_jurusan')
            ->select('prodi.*', 'jurusan.jurusan')
            ->orderBy('id_prodi')
            ->paginate(10); // Menampilkan 10 data per halaman

        return view('admin.data_prodi.prodi', compact('data_prodi'));
    }

    /**
     * Menampilkan form tambah data prodi baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data_jurusan = DB::table('jurusan')->get(); // Ambil semua jurusan untuk dropdown
        return view('admin.data_prodi.form_prodi', compact('data_jurusan'));
    }

    /**
     * Menyimpan data prodi baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'kode_prodi' => 'required|unique:prodi,kode_prodi',
            'prodi' => 'required|unique:prodi,prodi',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'jenjang' => 'required|string|in:D3,D4',
        ]);

        // Simpan data ke tabel 'prodi'
        DB::table('prodi')->insert([
            'kode_prodi' => $validatedData['kode_prodi'],
            'prodi' => $validatedData['prodi'],
            'jurusan_id' => $validatedData['jurusan_id'],
            'jenjang' => $validatedData['jenjang'],
        ]);

        return redirect()->route('prodi')
                         ->with('success', 'Prodi created successfully.');
    }

    /**
     * Menampilkan form edit untuk prodi berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $prodi = Prodi::where('id_prodi', $id)->first();
        $data_jurusan = DB::table('jurusan')->get(); // Data jurusan untuk dropdown

        return view('admin.data_prodi.edit_prodi', compact('prodi', 'data_jurusan'));
    }

    /**
     * Memperbarui data prodi berdasarkan ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID dari data prodi yang akan diperbarui
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'prodi' => 'required',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'jenjang' => 'required'
        ]);

        // Data baru yang akan disimpan
        $data = [
            'prodi' => $request->prodi,
            'jurusan_id' => $request->jurusan_id,
            'jenjang' => $request->jenjang,
        ];

        // Update data berdasarkan ID
        DB::table('prodi')->where('id_prodi', $id)->update($data);

        return redirect()->route('prodi')
                         ->with('success', 'Prodi updated successfully.');
    }

    /**
     * Menghapus data prodi berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        DB::table('prodi')->where('id_prodi', $id)->delete();

        return redirect()->route('prodi')
                         ->with('success', 'Prodi deleted successfully.');
    }
}
