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

class MahasiswaController extends Controller
{
    public function index()
    {
        $data_mahasiswa = DB::table('mahasiswa')
        ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('mahasiswa.*', 'jurusan.jurusan','prodi.prodi')
            ->orderBy('id_mhs')
            ->get();

        return view('admin.data_mahasiswa.mahasiswa', compact('data_mahasiswa'));
    }

    function export_excel(){
        return Excel::download(new ExportMahasiswa, "mahasiswa.xlsx");
    }
    public function import_excel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('file');
        $name_file = rand() . $file->getClientOriginalName();
        $file->move(public_path('file_mahasiswa'), $name_file);

        Excel::import(new ImportMahasiswa, public_path('file_mahasiswa/'.$name_file));
        return back()->with('success', 'File has been imported successfully');
    }


    public function create()
    {
        $data_jurusan = DB::table('jurusan')->get(); // Get all jurusan for the dropdown
        $data_prodi = DB::table('prodi')->get(); // Get all prodi for the dropdown
        return view('admin.data_mahasiswa.form_mahasiswa', compact('data_jurusan', 'data_prodi'));
    }
    public function show($id_mhs)
    {
        // Mengambil data mahasiswa berdasarkan id beserta data prodi-nya
        $mahasiswa = DB::table('mahasiswa')
        ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
        ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('mahasiswa.*', 'jurusan.jurusan','prodi.prodi')
            ->where('mahasiswa.id_mhs', $id_mhs)
            ->first();

        // Kirim data mahasiswa ke view detailMahasiswa
        return view('admin.data_mahasiswa.detail_mahasiswa', compact('mahasiswa'));
    }

    public function getProdi($jurusan_id)
{
    $prodi = Prodi::where('jurusan_id', $jurusan_id)->get();
    return response()->json($prodi);
}


    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan', // Corrected
            'prodi_id' => 'required|exists:prodi,id_prodi', // Ensure this is valid
            'gender' => 'required|string',
            'email' => 'required|string|max:20',
            'password' => 'required|string|max:16',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi file image
        ]);

        $jurusan = DB::table('jurusan')->where('id_jurusan', $validatedData['jurusan_id'])->first();
        $prodi = DB::table('prodi')->where('id_prodi', $validatedData['prodi_id'])->first();
        if ($prodi->jurusan_id !== $jurusan->id_jurusan) {
            return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak sesuai dengan Jurusan yang dipilih.']);
        }
        // Proses upload file gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Buat nama unik untuk gambar dengan menambahkan timestamp
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/mahasiswa'), $imageName);
        } else {
            $imageName = null;
        }


        // Handle upload gambar jika ada
        // $imagePath = $request->hasFile('image')
        // ? $request->file('image')->storeAs('Images/mahasiswa',
        // $request->file('image')->getClientOriginalName(), 'public')
        // : 'images/mahasiswa/default.jpg';

        // Insert data mahasiswa ke database
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
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            if (!$user->hasRole('mahasiswa')) {
                $user->assignRole('mahasiswa');
            }
        }

        return redirect()->route('mahasiswa')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id); // Cari mahasiswa berdasarkan id_mhs
        $data_jurusan = DB::table('jurusan')->get(); // Ambil data jurusan untuk dropdown
        $data_prodi = DB::table('prodi')->get(); // Ambil data prodi untuk dropdown

        return view('admin.data_mahasiswa.mahasiswa_edit', compact('mahasiswa', 'data_jurusan', 'data_prodi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nim' => 'required|unique:mahasiswa,nim,' . $id . ',id_mhs',
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan', // Corrected
            'prodi_id' => 'required|exists:prodi,id_prodi',
            'gender' => 'required|string',
            'email' => 'nullable|string|email|unique:mahasiswa,email,' . $id . ',id_mhs', // Unique validation ignoring the current email
            'password' => 'nullable|string|min:6|confirmed', // Optional password field
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);

        // Optional: Check if the selected prodi_id belongs to the selected jurusan_id
        $jurusan = DB::table('jurusan')->where('id_jurusan', $validatedData['jurusan_id'])->first();
        $prodi = DB::table('prodi')->where('id_prodi', $validatedData['prodi_id'])->first();
        if ($prodi->jurusan_id !== $jurusan->id_jurusan) {
            return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak sesuai dengan Jurusan yang dipilih.']);
        }

        // Handle upload gambar jika ada
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

        // Update data mahasiswa
        $mahasiswa->nim = $validatedData['nim'];
        $mahasiswa->nama = $validatedData['nama'];
        $mahasiswa->jurusan_id = $validatedData['jurusan_id'];
        $mahasiswa->prodi_id = $validatedData['prodi_id'];
        $mahasiswa->gender = $validatedData['gender'];
        $mahasiswa->email = $validatedData['email'] ?? $mahasiswa->email;
       // $mahasiswa->password = $validatedData['password'];
        $mahasiswa->save();

        return redirect()->route('mahasiswa')
            ->with('success', 'Mahasiswa berhasil diupdate.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Hapus gambar jika ada
        if ($mahasiswa->image) {
            Storage::disk('public')->delete($mahasiswa->image);
        }

        // Hapus mahasiswa dari database
        $mahasiswa->delete();

        return redirect()->route('mahasiswa')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
