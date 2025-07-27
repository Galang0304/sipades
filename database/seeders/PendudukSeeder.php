<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use App\Models\User;
use Carbon\Carbon;

class PendudukSeeder extends Seeder
{
    public function run()
    {
        // Create penduduk for existing users
        $users = User::all();
        
        $pendudukData = [
            [
                'nik' => '3201234567890001',
                'nama_lengkap' => 'Administrator',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-01-01',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Admin No. 1, RT 001/RW 001',
                'agama' => 'Islam',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Administrator',
                'status_penduduk' => 'Tetap'
            ],
            [
                'nik' => '3201234567890002',
                'nama_lengkap' => 'Lurah Desa',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1975-06-15',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Lurah No. 2, RT 002/RW 001',
                'agama' => 'Islam',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Lurah',
                'status_penduduk' => 'Tetap'
            ],
            [
                'nik' => '3201234567890003',
                'nama_lengkap' => 'Petugas Desa',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1985-03-20',
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Jl. Petugas No. 3, RT 003/RW 001',
                'agama' => 'Islam',
                'status_perkawinan' => 'Belum Kawin',
                'pekerjaan' => 'Petugas Desa',
                'status_penduduk' => 'Tetap'
            ],
            [
                'nik' => '3201234567890004',
                'nama_lengkap' => 'Warga Desa',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1990-12-10',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Warga No. 4, RT 004/RW 002',
                'agama' => 'Islam',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Swasta',
                'status_penduduk' => 'Tetap'
            ]
        ];

        foreach ($pendudukData as $data) {
            Penduduk::firstOrCreate(
                ['nik' => $data['nik']],
                $data
            );
        }

        // Update users with NIK
        $userNikMapping = [
            'admin@sipades.com' => '3201234567890001',
            'lurah@sipades.com' => '3201234567890002',
            'petugas@sipades.com' => '3201234567890003',
            'warga@sipades.com' => '3201234567890004'
        ];

        foreach ($userNikMapping as $email => $nik) {
            User::where('email', $email)->update(['nik' => $nik]);
        }

        $this->command->info('Penduduk data seeded successfully!');
    }
}
