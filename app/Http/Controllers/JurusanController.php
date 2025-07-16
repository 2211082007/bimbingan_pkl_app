<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    public function index()
    {
        $data_jurusan = DB::table('jurusan')->orderBy('id_jurusan')->get();
        return view('admin.data_jurusan.jurusan', compact('data_jurusan'));
    }

    public function create()
    {
        return view('admin.data_jurusan.form_jurusan');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_jurusan' => 'required|string',
            'jurusan' => 'required|string|max:255|unique:jurusan,jurusan',
        ]);

        DB::table('jurusan')->insert([
            'kode_jurusan' => $request->kode_jurusan,
            'jurusan' => $validatedData['jurusan'],
        ]);

        return redirect()->route('jurusan')
                         ->with('success', 'Jurusan created successfully.');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id); // Menggunakan findOrFail untuk menangani error
        return view('admin.data_jurusan.edit_jurusan', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jurusan' => 'required|string',
            'jurusan' => 'required|string|max:255|unique:jurusan,jurusan,' . $id . ',id_jurusan',
        ]);

        $data = [
            'kode_jurusan' => $request->kode_jurusan,
            'jurusan' => $request->jurusan,
        ];

        DB::table('jurusan')->where('id_jurusan', $id)->update($data);

        return redirect()->route('jurusan')
                         ->with('success', 'Jurusan updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('jurusan')->where('id_jurusan', $id)->delete();

        return redirect()->route('jurusan')
                         ->with('success', 'Jurusan deleted successfully.');
    }
}
