<?php

namespace App\Http\Controllers;

use App\Exports\ExportDosen;
use App\Imports\ImportDosen;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller untuk mengelola data dosen:
 * - Tambah, edit, hapus dosen
 * - Import/export data Excel
 * - Validasi relasi antar data (jurusan-prodi)
 */
class DosenController extends Controller
{
    /**
     * Menampilkan semua data dosen ke halaman admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data_dosen = DB::table('dosen')
            ->join('jurusan', 'dosen.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->join('golongan', 'dosen.golongan_id', '=', 'golongan.id_golongan')
            ->select('dosen.*', 'prodi.prodi', 'jurusan.jurusan', 'golongan.golongan')
            ->orderBy('id_dosen')
            ->get();

        return view('admin.data_dosen.dosen', compact('data_dosen'));
    }

    /**
     * Mengekspor data dosen ke file Excel (.xlsx).
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export_excel()
    {
        return Excel::download(new ExportDosen, "dosen.xlsx");
    }

    /**
     * Mengimpor data dosen dari file Excel.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import_excel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv,xls']);

        $file = $request->file('file');
        $filePath = $file->storeAs('file_dosen', uniqid() . '_' . $file->getClientOriginalName(), 'public');

        Excel::import(new ImportDosen, storage_path('app/public/' . $filePath));

        return back()->with('success', 'File berhasil diimpor.');
    }

    /**
     * Menampilkan detail dosen berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $dosen = DB::table('dosen')
            ->join('jurusan', 'dosen.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->join('golongan', 'dosen.golongan_id', '=', 'golongan.id_golongan')
            ->select('dosen.*', 'jurusan.jurusan as jurusan', 'prodi.prodi as prodi', 'golongan.golongan as golongan')
            ->where('dosen.id_dosen', $id)
            ->first();

        return view('admin.data_dosen.detail_dosen', compact('dosen'));
    }

    /**
     * Menampilkan form untuk menambah dosen baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data_jurusan = DB::table('jurusan')->get();
        $data_prodi = DB::table('prodi')->get();
        $data_golongan = DB::table('golongan')->get();

        return view('admin.data_dosen.form_dosen', compact('data_jurusan', 'data_prodi', 'data_golongan'));
    }

    /**
     * Menyimpan data dosen baru ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'id_dosen' => 'required|unique:dosen,id_dosen',
        'nidn' => 'required|unique:dosen,nidn',
        'nama' => 'required|string|max:255',
        'nip' => 'required|unique:dosen,nip',
        'gender' => 'required|string',
        'tempt_lahir' => 'required|string',
        'tgl_lahir' => 'required|date',
        'pendidikan' => 'required|string',
        'jurusan_id' => 'required|exists:jurusan,id_jurusan',
        'prodi_id' => 'required|exists:prodi,id_prodi',
        'alamat' => 'required|string',
        'email' => 'required|email|unique:dosen,email',
        'password' => 'required|string|max:16',
        'no_hp' => 'required|string',
        'golongan_id' => 'required|exists:golongan,id_golongan',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status' => 'required|string',
    ]);

    // Validate jurusan and prodi consistency
    $jurusan = DB::table('jurusan')->where('id_jurusan', $validated['jurusan_id'])->first();
    $prodi = DB::table('prodi')->where('id_prodi', $validated['prodi_id'])->first();
    if ($prodi->jurusan_id !== $jurusan->id_jurusan) {
        return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak sesuai dengan Jurusan yang dipilih.']);
    }

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        try {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images/dosen', $imageName, 'public');
            $imagePath = 'images/dosen/' . $imageName;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['image' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
        }
    }

    // Save to dosen table using Eloquent
    $dosen = Dosen::create([
        'id_dosen' => $validated['id_dosen'],
        'nidn' => $validated['nidn'],
        'nama' => $validated['nama'],
        'nip' => $validated['nip'],
        'gender' => $validated['gender'],
        'tempt_lahir' => $validated['tempt_lahir'],
        'tgl_lahir' => $validated['tgl_lahir'],
        'pendidikan' => $validated['pendidikan'],
        'jurusan_id' => $validated['jurusan_id'],
        'prodi_id' => $validated['prodi_id'],
        'alamat' => $validated['alamat'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'no_hp' => $validated['no_hp'],
        'golongan_id' => $validated['golongan_id'],
        'image' => $imagePath,
        'status' => $validated['status'],
    ]);

    // Create user account
    $user = User::create([
        'name' => $validated['nama'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);
    $user->assignRole('dosen');

    return redirect()->route('dosen')->with('success', 'Dosen berhasil ditambahkan.');
}

    /**
     * Menampilkan form edit dosen.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        $data_jurusan = DB::table('jurusan')->get();
        $data_prodi = DB::table('prodi')->get();
        $data_golongan = DB::table('golongan')->get();

        return view('admin.data_dosen.dosen_edit', compact('dosen', 'data_jurusan', 'data_prodi', 'data_golongan'));
    }

    /**
     * Memperbarui data dosen yang sudah ada.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $validated = $request->validate([
            'nidn' => 'required|unique:dosen,nidn,' . $id . ',id_dosen',
            'nama' => 'required|string|max:255',
            'nip' => 'required|unique:dosen,nip,' . $id . ',id_dosen',
            'gender' => 'required|string',
            'tempt_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'pendidikan' => 'required|string',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'prodi_id' => 'required|exists:prodi,id_prodi',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'golongan_id' => 'required|exists:golongan,id_golongan',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|string',
        ]);

        $jurusan = DB::table('jurusan')->where('id_jurusan', $validated['jurusan_id'])->first();
        $prodi = DB::table('prodi')->where('id_prodi', $validated['prodi_id'])->first();
        if ($prodi->jurusan_id !== $jurusan->id_jurusan) {
            return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak sesuai dengan Jurusan yang dipilih.']);
        }

        // Ganti gambar jika ada
        if ($request->hasFile('image')) {
            if ($dosen->image) {
                $oldImagePath = public_path('images/dosen/' . $dosen->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/dosen'), $imageName);
        } else {
            $imageName = $dosen->image;
        }

        // Update data
        $dosen->nidn = $validated['nidn'];
        $dosen->nama = $validated['nama'];
        $dosen->nip = $validated['nip'];
        $dosen->gender = $validated['gender'];
        $dosen->tempt_lahir = $validated['tempt_lahir'];
        $dosen->tgl_lahir = $validated['tgl_lahir'];
        $dosen->pendidikan = $validated['pendidikan'];
        $dosen->jurusan_id = $validated['jurusan_id'];
        $dosen->prodi_id = $validated['prodi_id'];
        $dosen->alamat = $validated['alamat'];
        $dosen->no_hp = $validated['no_hp'];
        $dosen->golongan_id = $validated['golongan_id'];
        $dosen->status = $validated['status'];
        $dosen->image = $imageName;
        $dosen->save();

        return redirect()->route('dosen')->with('success', 'Dosen berhasil diperbarui.');
    }

    /**
     * Menghapus data dosen berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
{
    $dosen = Dosen::findOrFail($id);

    // Check if the image exists before attempting to delete
    if ($dosen->image) {
        Storage::disk('public')->delete($dosen->image);
    }

    $dosen->delete();

    return redirect()->route('dosen')->with('success', 'Dosen berhasil dihapus.');
}
}
