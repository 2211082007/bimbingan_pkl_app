<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PimpinanProdi;
use App\Models\User;
use App\Models\UsulanPKL;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'superAdmin']);
        $adminRole = Role::create(['name' => 'admin']);

        $kaprodiRole = Role::create(['name' => 'kaprodi']);
        $mahasiswaRole = Role::firstOrCreate(['name' => 'mahasiswa']);
        $dosenRole = Role::firstOrCreate(['name' => 'dosen']);

        //pkl
        $mahasiswaPklRole = Role::firstOrCreate(['name' => 'mahasiswaPkl']);
        $pembimbingPklRole = Role::firstOrCreate(['name' => 'pembimbingPkl']);


        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $adminUser->assignRole($adminRole);

        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $superAdminUser->assignRole($superAdminRole);

        $mahasiswas = Mahasiswa::all();
        $dosens = Dosen::all();
        $mahasiswaPklIds = UsulanPKL::pluck('mhs_id')->toArray();
        $pembimbingPklIds = UsulanPKL::pluck('pembimbing_id')->toArray();
        $kaprodiIds = PimpinanProdi::pluck('dosen_id')->toArray();


        foreach ($dosens as $dosen) {
            $existingUser = User::where('email', $dosen->email)->first();

            if ($existingUser) {
                $existingUser->assignRole($dosenRole);

                if (in_array($dosen->id_dosen, $pembimbingPklIds)) {
                    $existingUser->assignRole($pembimbingPklRole);
                }


                if (in_array($dosen->id_dosen, $kaprodiIds)) {
                    $existingUser->assignRole($kaprodiRole);
                }


            } else {
                $user = User::create([
                    'name' => $dosen->nama,
                    'email' => $dosen->email,
                    'password' => $dosen->password,
                ]);

                $user->assignRole($dosenRole);

                if (in_array($dosen->id_dosen, $pembimbingPklIds)) {
                    $user->assignRole($pembimbingPklRole);
                }

                if (in_array($dosen->id_dosen, $kaprodiIds)) {
                    $user->assignRole($kaprodiRole);
                }

            }
        }

        foreach ($mahasiswas as $mahasiswa) {
            $existingUser = User::where('email', $mahasiswa->email)->first();

            if ($existingUser) {
                $existingUser->assignRole($mahasiswaRole);

                if (in_array($mahasiswa->id_mhs, $mahasiswaPklIds)) {
                    $existingUser->assignRole($mahasiswaPklRole);
                }

            } else {
                $user = User::create([
                    'name' => $mahasiswa->nama,
                    'email' => $mahasiswa->email,
                    'password' => $mahasiswa->password,
                ]);

                $user->assignRole($mahasiswaRole);

                if (in_array($mahasiswa->id_mhs, $mahasiswaPklIds)) {
                    $user->assignRole($mahasiswaPklRole);
                }

            }
        }
    }
}
