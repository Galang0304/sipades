<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run()
    {
        // Create sample penduduk data first
        $pendudukAdmin = Penduduk::create([
            'nik' => '6371010101010001',
            'nama_lengkap' => 'Administrator System',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Kelurahan Kuin Selatan No. 1',
            'agama' => 'Islam',
            'jenis_kelamin' => 'Laki-laki',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Pegawai Negeri Sipil',
            'status_penduduk' => 'Tetap'
        ]);

        $pendudukLurah = Penduduk::create([
            'nik' => '6371010101010002',
            'nama_lengkap' => 'Lurah Kuin Selatan',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => '1985-05-15',
            'alamat' => 'Jl. Kelurahan Kuin Selatan No. 2',
            'agama' => 'Islam',
            'jenis_kelamin' => 'Laki-laki',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Lurah',
            'status_penduduk' => 'Tetap'
        ]);

        $pendudukPetugas = Penduduk::create([
            'nik' => '6371010101010003',
            'nama_lengkap' => 'Petugas Kelurahan',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => '1992-08-20',
            'alamat' => 'Jl. Kelurahan Kuin Selatan No. 3',
            'agama' => 'Islam',
            'jenis_kelamin' => 'Perempuan',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Pegawai Honorer',
            'status_penduduk' => 'Tetap'
        ]);

        $pendudukMember = Penduduk::create([
            'nik' => '6371010101010004',
            'nama_lengkap' => 'Warga Test',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => '1995-12-10',
            'alamat' => 'Jl. Kuin Selatan No. 100',
            'agama' => 'Islam',
            'jenis_kelamin' => 'Laki-laki',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Wiraswasta',
            'status_penduduk' => 'Tetap'
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sipades.com',
            'password' => Hash::make('password'),
            'nik' => $pendudukAdmin->nik,
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create lurah user
        $lurah = User::create([
            'name' => 'Lurah Kuin Selatan',
            'email' => 'lurah@sipades.com',
            'password' => Hash::make('password'),
            'nik' => $pendudukLurah->nik,
            'is_active' => true,
        ]);
        $lurah->assignRole('lurah');

        // Create petugas user
        $petugas = User::create([
            'name' => 'Petugas Kelurahan',
            'email' => 'petugas@sipades.com',
            'password' => Hash::make('password'),
            'nik' => $pendudukPetugas->nik,
            'is_active' => true,
        ]);
        $petugas->assignRole('petugas');

        // Create member user
        $member = User::create([
            'name' => 'Warga Test',
            'email' => 'warga@sipades.com',
            'password' => Hash::make('password'),
            'nik' => $pendudukMember->nik,
            'is_active' => true,
        ]);
        $member->assignRole('user');
    }
}
