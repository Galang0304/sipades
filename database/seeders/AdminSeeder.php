<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create petugas role if it doesn't exist
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);

        // Reset admin role's permissions
        $adminRole->syncPermissions([
            'manage-users',
            'manage-penduduk',
            'manage-surat',
            'validate-surat',
            'manage-pengaduan',
            'manage-informasi',
            'view-reports'
        ]);
        
        // Set petugas role's permissions (similar to admin but can be limited)
        $petugasRole->syncPermissions([
            'manage-users',
            'manage-penduduk',
            'manage-surat',
            'validate-surat',
            'manage-pengaduan',
            'manage-informasi',
            'view-reports'
        ]);

        // Create penduduk data for admin
        $penduduk = Penduduk::create([
            'nik' => '6371999901010001',
            'nama_lengkap' => 'Administrator',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Admin No. 1',
            'agama' => 'Islam',
            'jenis_kelamin' => 'Laki-laki',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Administrator Sistem',
            'status_penduduk' => 'Tetap'
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@kuinsel.com',
            'password' => Hash::make('admin123'),
            'nik' => $penduduk->nik,
            'is_active' => true
        ]);

        // Assign admin role
        $admin->assignRole('admin');
        
        // Create petugas data
        $petugasPenduduk = Penduduk::create([
            'nik' => '6371999901010002',
            'nama_lengkap' => 'Petugas Pelayanan',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => '1992-05-15',
            'alamat' => 'Jl. Petugas No. 2',
            'agama' => 'Islam',
            'jenis_kelamin' => 'Perempuan',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Petugas Pelayanan',
            'status_penduduk' => 'Tetap'
        ]);

        // Create petugas user
        $petugas = User::create([
            'name' => 'Petugas Pelayanan',
            'email' => 'petugas@kuinsel.com',
            'password' => Hash::make('petugas123'),
            'nik' => $petugasPenduduk->nik,
            'is_active' => true
        ]);

        // Assign petugas role
        $petugas->assignRole('petugas');
    }
}
