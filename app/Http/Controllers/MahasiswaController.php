<?php

namespace App\Http\Controllers;

use App\Exports\ExportMahasiswa;
use App\Imports\ImportMahasiswa;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller untuk mengelola data mahasiswa:
 * - Menampilkan, menambah, mengedit, menghapus, import/export, dan relasi prodi-jurusan.
 */
class MahasiswaController extends Controller
{
    /**
     * Menampilkan seluruh data mahasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data_mahasiswa = DB::table('mahasiswa')
            ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('mahasiswa.*', 'jurusan.jurusan', 'prodi.prodi')
            ->orderBy('id_mhs')
            ->get();

        return view('admin.data_mahasiswa.mahasiswa', compact('data_mahasiswa'));
    }

    /**
     * Mengekspor data mahasiswa ke file Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export_excel()
    {
        return Excel::download(new ExportMahasiswa, "mahasiswa.xlsx");
    }

    /**
     * Mengimpor data mahasiswa dari file Excel.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import_excel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('file');
        $name_file = rand() . $file->getClientOriginalName();
        $file->move(public_path('file_mahasiswa'), $name_file);

        Excel::import(new ImportMahasiswa, public_path('file_mahasiswa/' . $name_file));

        return back()->with('success', 'File has been imported successfully');
    }

    /**
     * Menampilkan form tambah mahasiswa baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data_jurusan = DB::table('jurusan')->get();
        $data_prodi = DB::table('prodi')->get();

        return view('admin.data_mahasiswa.form_mahasiswa', compact('data_jurusan', 'data_prodi'));
    }

    /**
     * Menampilkan detail data mahasiswa berdasarkan ID.
     *
     * @param int $id_mhs
     * @return \Illuminate\View\View
     */
    public function show($id_mhs)
    {
        $mahasiswa = DB::table('mahasiswa')
            ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('mahasiswa.*', 'jurusan.jurusan', 'prodi.prodi')
            ->where('mahasiswa.id_mhs', $id_mhs)
            ->first();

        return view('admin.data_mahasiswa.detail_mahasiswa', compact('mahasiswa'));
    }

    /**
     * Mengembalikan daftar prodi berdasarkan ID jurusan (digunakan untuk AJAX dinamis).
     *
     * @param int $jurusan_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProdi($jurusan_id)
    {
        $prodi = Prodi::where('jurusan_id', $jurusan_id)->get();
        return response()->json($prodi);
    }

    /**
     * Menyimpan data mahasiswa baru ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'prodi_id' => 'required|exists:prodi,id_prodi',
            'gender' => 'required|string',
            'email' => 'required|string|max:20',
            'password' => 'required|string|max:16',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek kesesuaian prodi dan jurusan
        $jurusan = DB::table('jurusan')->where('id_jurusan', $validatedData['jurusan_id'])->first();
        $prodi = DB::table('prodi')->where('id_prodi', $validatedData['prodi_id'])->first();
        if ($prodi->jurusan_id !== $jurusan->id_jurusan) {
            return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak sesuai dengan Jurusan yang dipilih.']);
        }

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/mahasiswa'), $imageName);
        } else {
            $imageName = null;
        }

        // Simpan data mahasiswa
        DB::table('mahasiswa')->insert([
            'nim' => $validatedData['nim'],
            'nama' => $validatedData['nama'],
            'jurusan_id' => $validatedData['jurusan_id'],
            'prodi_id' => $validatedData['prodi_id'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'image' => $imageName,
        ]);

        // Buat akun user
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user && !$user->hasRole('mahasiswa')) {
            $user->assignRole('mahasiswa');
        }

        return redirect()->route('mahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit data mahasiswa.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $data_jurusan = DB::table('jurusan')->get();
        $data_prodi = DB::table('prodi')->get();

        return view('admin.data_mahasiswa.mahasiswa_edit', compact('mahasiswa', 'data_jurusan', 'data_prodi'));
    }

    /**
     * Memperbarui data mahasiswa berdasarkan ID.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nim' => 'required|unique:mahasiswa,nim,' . $id . ',id_mhs',
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'prodi_id' => 'required|exists:prodi,id_prodi',
            'gender' => 'required|string',
            'email' => 'nullable|string|email|unique:mahasiswa,email,' . $id . ',id_mhs',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);

        // Validasi jurusan-prodi konsisten
        $jurusan = DB::table('jurusan')->where('id_jurusan', $validatedData['jurusan_id'])->first();
        $prodi = DB::table('prodi')->where('id_prodi', $validatedData['prodi_id'])->first();
        if ($prodi->jurusan_id !== $jurusan->id_jurusan) {
            return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak sesuai dengan Jurusan yang dipilih.']);
        }

        // Update gambar jika diunggah
        if ($request->hasFile('image')) {
            if ($mahasiswa->image) {
                $oldImagePath = public_path('images/mahasiswa/' . $mahasiswa->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/mahasiswa'), $imageName);
        } else {
            $imageName = $mahasiswa->image;
        }

        // Simpan data yang diperbarui
        $mahasiswa->nim = $validatedData['nim'];
        $mahasiswa->nama = $validatedData['nama'];
        $mahasiswa->jurusan_id = $validatedData['jurusan_id'];
        $mahasiswa->prodi_id = $validatedData['prodi_id'];
        $mahasiswa->gender = $validatedData['gender'];
        $mahasiswa->email = $validatedData['email'] ?? $mahasiswa->email;
        $mahasiswa->image = $imageName;
        $mahasiswa->save();

        return redirect()->route('mahasiswa')->with('success', 'Mahasiswa berhasil diupdate.');
    }

    /**
     * Menghapus data mahasiswa dan file gambar jika ada.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        if ($mahasiswa->image) {
            Storage::disk('public')->delete($mahasiswa->image);
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
