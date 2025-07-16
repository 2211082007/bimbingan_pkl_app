<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\UsulanPKL;
use App\Models\BimbinganPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BimbinganController extends Controller
{
    public function index(Request $request)
{
    $role = $request->query('role');
    $user = auth()->user();


    $dosen_id = optional($user->dosen)->id_dosen;
    $mhs_id = optional($user->mahasiswa)->id_mhs;


    $pkl_pembimbing = UsulanPKL::with(['mahasiswa', 'mahasiswa.prodi'])
        ->when($dosen_id, function ($query) use ($dosen_id) {
            $query->where('pembimbing_id', $dosen_id);
        })
        ->where('konfirmasi', '1') // Data yang sudah dikonfirmasi
        ->get();

    // Ambil data untuk mahasiswa (jika mhs_id tidak null)
    $pkl_mahasiswa = UsulanPKL::with(['mahasiswa', 'mahasiswa.prodi'])
        ->when($mhs_id, function ($query) use ($mhs_id) {
            $query->where('mhs_id', $mhs_id);
        })
        ->where('konfirmasi', '1') // Data yang sudah dikonfirmasi
        ->get();

    return view('bimbingan.bimbingan_pkl', compact('pkl_pembimbing', 'pkl_mahasiswa', 'role'));
}

    public function show($id)
    {
        // Ambil data usulan PKL dan semua data bimbingan terkait
        $data_mhs = Mahasiswa::where('id_mhs', $id)->first();
        // dd($data_mhs);
        $data_usulanpkl = UsulanPKL::where('mhs_id', $data_mhs->id_mhs)->first();
        // dd($id);
        $data_bimbinganPkl = BimbinganPkl::where('usulan_id', $data_usulanpkl->id_usulan)->get();
        //dd($data_bimbinganPkl);


        //     $data_bimbinganPkl = BimbinganPkl::whereHas('usulan_pkl', function($query) use ($id) {
        //     $query->where('mhs_id', $id);
        // })
        // ->get();
        return view('bimbingan.detail_logbook', compact('data_mhs', 'data_usulanpkl', 'data_bimbinganPkl'));
    }


    public function create($id)
    {
        $data_usulanpkl = UsulanPKL::with('mahasiswa')->where('id_usulan', $id)->firstOrFail();
        // dd($data_usulanpkl);
        $data_bimbinganPkl = BimbinganPkl::all();
        $dosen = Dosen::all();
        return view('bimbingan.form_bimbingan', compact('data_usulanpkl', 'data_bimbinganPkl', 'dosen'));
    }

    public function store(Request $request)
    {

        // Validate input
        $validatedData = $request->validate([
            // 'id' => 'required|exists:usulan_pkl,id_usulan',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'kegiatan' => 'required|string',
            'laporan' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('laporan')) {
            $file = $request->file('laporan');
            $path = $file->store('bimbingan_files', 'public');
            $validatedData['laporan'] = $path;
        }

        $mhs = Mahasiswa::where('email', Auth::user()->email)->first();
        // Save data to bimbingan_pkl table
        BimbinganPkl::create([
            'usulan_id' => $request->id,
            'tgl_awal' => $validatedData['tgl_awal'],
            'tgl_akhir' => $validatedData['tgl_akhir'],
            'kegiatan' => $validatedData['kegiatan'],
            'laporan' => $validatedData['laporan'],
        ]);

        // Redirect back with success message
        return redirect()->route('logbook.view', ['id' => $mhs->id_mhs])
            ->with('success', 'Logbook entry successfully added.');
    }


    public function edit($id)
    {
        $data_bimbinganPkl = BimbinganPKL::findOrFail($id);
        $data_usulanpkl = UsulanPKL::all();
        return view('bimbingan.bimbinganPkl_edit', compact('data_bimbinganPkl', 'data_usulanpkl'));
    }

    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::where('email', Auth::user()->email)->first();

        $validatedData = $request->validate([
            'usulan_id' => 'required|exists:usulan_pkl,id_usulan',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'kegiatan' => 'required|string',
            'laporan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data_bimbinganPkl = BimbinganPkl::findOrFail($id);

        if ($request->hasFile('laporan')) {
            $file = $request->file('laporan');
            $path = $file->store('bimbingan_files', 'public');
            $validatedData['laporan'] = $path;
        }

        $data_bimbinganPkl->update([
            'usulan_id' => $validatedData['usulan_id'],
            'tgl_awal' => $validatedData['tgl_awal'],
            'tgl_akhir' => $validatedData['tgl_akhir'],
            'kegiatan' => $validatedData['kegiatan'],
            'laporan' => $validatedData['laporan'] ?? $data_bimbinganPkl->laporan,
        ]);

        return redirect()->route('logbook.view', ['id' => $mhs->id_mhs])
            ->with('success', 'Logbook entry successfully updated.');
    }

    public function destroy($id)
    {
        $data_bimbinganPkl = BimbinganPkl::findOrFail($id);
        $usulanId = $data_bimbinganPkl->usulan_id;
        $data_bimbinganPkl->delete();

        return redirect()->route('logbook.view', ['id' => $usulanId])
            ->with('success', 'Logbook entry successfully deleted.');
    }
}
