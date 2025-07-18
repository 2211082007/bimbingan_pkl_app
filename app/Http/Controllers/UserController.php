<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateAkun(Request $request)
{
    /** @var \App\Models\User $user */
$user = Auth::user();
   $role = $user->roles->pluck('name')->first();


    $rules = [
        'nama' => 'required|string|max:255',
        'password' => 'nullable|string|min:6',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    $request->validate($rules);

    // Dapatkan data dari relasi mahasiswa atau dosen
    if (in_array($role, ['mahasiswa', 'mahasiswaPkl'])) {
        $data = $user->mahasiswa;
    } elseif (in_array($role, ['dosen', 'kaprodi', 'pembimbingPkl'])) {
        $data = $user->dosen;
    } else {
        return redirect()->back()->withErrors(['role' => 'Role tidak valid']);
    }

    // Update nama
    $data->nama = $request->nama;

    // Jika upload image baru
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('profile', 'public');
        $data->image = $imagePath;
    }

    // Simpan perubahan data profil
    $data->save();

    // Update password jika diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
        $user->save();
    }

    return redirect()->route('dashboard')->with('success', 'Akun berhasil diperbarui');
}
}
