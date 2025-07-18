<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;



class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $role = $user->roles->pluck('name')->first();


        if ($role === 'admin') {
            return view('layouts.dashboard', [
                'user' => $user,
                'role' => $role,
                'jumlahMahasiswa' => Mahasiswa::count(),
                'jumlahDosen' => Dosen::count(),
                'jumlahProdi' => Prodi::count(),
                'jumlahJurusan' => Jurusan::count(),
            ]);
        }

        return view('layouts.dashboard', [
            'user' => $user,
            'role' => $role
        ]);
    }
    
}
