<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdiController extends Controller
{
    public function index()
    {
        $data_prodi = DB::table('prodi')
        ->join('jurusan', 'prodi.jurusan_id', '=', 'jurusan.id_jurusan')
        ->select('prodi.*', 'jurusan.jurusan')
            ->orderBy('id_prodi') // Order by id_prodi from smallest to largest

            ->paginate(10);



        return view('admin.data_prodi.prodi', compact('data_prodi'));
    }

    public function create()
{
    $data_jurusan = DB::table('jurusan')->get(); // Ambil semua data jurusan dari tabel 'jurusan'
    return view('admin.data_prodi.form_prodi', compact('data_jurusan')); // Kirim data ke view
}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_prodi' => 'required|string',
            'prodi' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'jenjang' => 'required|string|in:D3,D4',

        ]);

        DB::table ('prodi') -> insert([
            'kode_prodi' => $validatedData['kode_prodi'],
            'prodi' => $validatedData['prodi'],

            'jurusan_id' => $validatedData['jurusan_id'],
            'jenjang' => $validatedData['jenjang'],
        ]);

        //Prodi::create($request->all());

        return redirect()->route('prodi')
                         ->with('success', 'Prodi created successfully.');
    }

    public function edit($id)
{
    $prodi = Prodi::where('id_prodi', $id)->first();
    $data_jurusan = DB::table('jurusan')->get(); // Ambil data jurusan
    return view('admin.data_prodi.edit_prodi', compact('prodi', 'data_jurusan'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'prodi' => 'required',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'jenjang' => 'required'
        ]);
        $data=[
            'prodi'=> $request->prodi,
            'jurusan_id'=> $request->jurusan_id,
            'jenjang'=> $request->jenjang,
        ];

        //$prodi = Prodi::find($id);
       // $prodi->update($request->all());

        DB::table('prodi')->where('id_prodi',$id)->update($data);
        return redirect()->route('prodi')
                         ->with('success', 'Prodi updated successfully.');
    }

    public function destroy($id)
    {
        DB::table ('prodi')->where('id_prodi',$id)->delete();
        //Prodi::destroy($id);
        return redirect()->route('prodi')
                         ->with('success', 'Prodi deleted successfully.');
    }
}
