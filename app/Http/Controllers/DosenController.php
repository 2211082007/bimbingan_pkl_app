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

class DosenController extends Controller
{
    // Menampilkan daftar dosen
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

    // Export data dosen ke Excel
    public function export_excel()
    {
        return Excel::download(new ExportDosen, "dosen.xlsx");
    }

    // Import data dosen dari Excel
    public function import_excel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv,xls']);

        $file = $request->file('file');
        $filePath = $file->storeAs('file_dosen', uniqid() . '_' . $file->getClientOriginalName(), 'public');

        Excel::import(new ImportDosen, storage_path('app/public/' . $filePath));

        return back()->with('success', 'File berhasil diimpor.');
    }
    public function show($id)
    {
        // Mengambil data mahasiswa berdasarkan id beserta data prodi-nya
        $dosen = DB::table('dosen')
        ->join('jurusan', 'dosen.jurusan_id', '=', 'jurusan.id_jurusan')
        ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
        ->join('golongan', 'dosen.golongan_id', '=', 'golongan.id_golongan')
        ->select(
            'dosen.*',
            'jurusan.jurusan as jurusan',
            'prodi.prodi as prodi',
            'golongan.golongan as golongan'
        )
        ->where('dosen.id_dosen', $id) // Replace $id with the actual identifier
        ->first();


        // Kirim data mahasiswa ke view detailMahasiswa
        return view('admin.data_dosen.detail_dosen', compact('dosen'));
    }

    // Form untuk menambah dosen
    public function create()
    {
        $data_jurusan = DB::table('jurusan')->get();
        $data_prodi = DB::table('prodi')->get();
        $data_golongan = DB::table('golongan')->get();

        return view('admin.data_dosen.form_dosen', compact('data_jurusan', 'data_prodi', 'data_golongan'));
    }

    // Menyimpan data dosen baru
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
        $jurusan = DB::table('jurusan')->where('id_jurusan', $validated['jurusan_id'])->first();
        $prodi = DB::table('prodi')->where('id_prodi', $validated['prodi_id'])->first();
        if ($prodi->jurusan_id !== $jurusan->id_jurusan) {
            return redirect()->back()->withErrors(['prodi_id' => 'Prodi tidak sesuai dengan Jurusan yang dipilih.']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Buat nama unik untuk gambar dengan menambahkan timestamp
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/dosen'), $imageName);
        } else {
            $imageName = null;
        }
        DB::table('dosen')->insert([
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
            'password' => $validated['password'],
            'no_hp' => $validated['no_hp'],
            'golongan_id' => $validated['golongan_id'],
            'image' => $imageName,
            'status' => $validated['status'],

        ]);

        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('dosen');

        return redirect()->route('dosen')->with('success', 'Dosen berhasil ditambahkan.');
    }

    // Form edit dosen
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        $data_jurusan = DB::table('jurusan')->get();
        $data_prodi = DB::table('prodi')->get();
        $data_golongan = DB::table('golongan')->get();

        return view('admin.data_dosen.dosen_edit', compact('dosen', 'data_jurusan', 'data_prodi', 'data_golongan'));
    }

    // Update data dosen
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
            // 'email' => 'nullable|email|unique:dosen,email,' . $id . ',id_dosen',
            // 'password' => 'nullable|string|min:6|confirmed', // Optional password field
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

        // Handle upload gambar jika ada
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

        // Update data mahasiswa
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
        // $dosen->email = $validated['email'];
        //  $dosen->password = $validated['password'];
         $dosen->no_hp = $validated['no_hp'];
         $dosen->golongan_id = $validated['golongan_id'];
         $dosen->status = $validated['status'];
        $dosen->save();


        return redirect()->route('dosen')->with('success', 'Dosen berhasil diperbarui.');
    }

    // Hapus dosen
    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        Storage::disk('public')->delete($dosen->image);
        $dosen->delete();

        return redirect()->route('dosen')->with('success', 'Dosen berhasil dihapus.');
    }
}
