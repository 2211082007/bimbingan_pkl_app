<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller untuk mengelola data Jurusan:
 * - Menampilkan, menambah, mengedit, dan menghapus data jurusan.
 */
class JurusanController extends Controller
{
    /**
     * Menampilkan seluruh data jurusan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data_jurusan = DB::table('jurusan')->orderBy('id_jurusan')->get();
        return view('admin.data_jurusan.jurusan', compact('data_jurusan'));
    }

    /**
     * Menampilkan form untuk menambahkan jurusan baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.data_jurusan.form_jurusan');
    }

    /**
     * Menyimpan data jurusan baru ke dalam database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kode_jurusan' => 'required|string',
            'jurusan' => 'required|string|max:255|unique:jurusan,jurusan',
        ]);

        // Simpan data ke tabel jurusan
        DB::table('jurusan')->insert([
            'kode_jurusan' => $request->kode_jurusan,
            'jurusan' => $validatedData['jurusan'],
        ]);

        return redirect()->route('jurusan')
                         ->with('success', 'Jurusan created successfully.');
    }

    /**
     * Menampilkan form untuk mengedit data jurusan berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id); // Jika tidak ditemukan, akan lempar 404
        return view('admin.data_jurusan.edit_jurusan', compact('jurusan'));
    }

    /**
     * Memperbarui data jurusan di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID jurusan yang akan diperbarui
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kode_jurusan' => 'required|string',
            'jurusan' => 'required|string|max:255|unique:jurusan,jurusan,' . $id . ',id_jurusan',
        ]);

        // Data yang akan diupdate
        $data = [
            'kode_jurusan' => $request->kode_jurusan,
            'jurusan' => $request->jurusan,
        ];

        DB::table('jurusan')->where('id_jurusan', $id)->update($data);

        return redirect()->route('jurusan')
                         ->with('success', 'Jurusan updated successfully.');
    }

    /**
     * Menghapus data jurusan berdasarkan ID.
     *
     * @param int $id ID jurusan yang akan dihapus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        DB::table('jurusan')->where('id_jurusan', $id)->delete();

        return redirect()->route('jurusan')
                         ->with('success', 'Jurusan deleted successfully.');
    }
}
