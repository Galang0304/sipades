<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Penduduk;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles if they don't exist
        $roles = ['admin', 'lurah', 'petugas', 'warga'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create Penduduk data first (for foreign key constraint)
        $pendudukData = [
            [
                'nik' => '1234567890123456',
                'nama_lengkap' => 'Administrator SIPADES',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-01-01',
                'agama' => 'Islam',
                'pekerjaan' => 'Administrator',
                'status_perkawinan' => 'Kawin',
                'status_penduduk' => 'Tetap',
                'alamat' => 'Jl. Admin No. 1, Desa Makmur',
            ],
            [
                'nik' => '1234567890123457',
                'nama_lengkap' => 'Lurah Desa Makmur',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1975-05-15',
                'agama' => 'Islam',
                'pekerjaan' => 'Lurah',
                'status_perkawinan' => 'Kawin',
                'status_penduduk' => 'Tetap',
                'alamat' => 'Jl. Lurah No. 1, Desa Makmur',
            ],
            [
                'nik' => '1234567890123458',
                'nama_lengkap' => 'Petugas Administrasi',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1985-08-20',
                'agama' => 'Islam',
                'pekerjaan' => 'Petugas Desa',
                'status_perkawinan' => 'Belum Kawin',
                'status_penduduk' => 'Tetap',
                'alamat' => 'Jl. Petugas No. 5, Desa Makmur',
            ],
            [
                'nik' => '1234567890123459',
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1990-03-10',
                'agama' => 'Islam',
                'pekerjaan' => 'Petani',
                'status_perkawinan' => 'Kawin',
                'status_penduduk' => 'Tetap',
                'alamat' => 'Jl. Sawah No. 12, Desa Makmur',
            ],
            [
                'nik' => '1234567890123460',
                'nama_lengkap' => 'Siti Aminah',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Solo',
                'tanggal_lahir' => '1992-07-25',
                'agama' => 'Islam',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'status_perkawinan' => 'Kawin',
                'status_penduduk' => 'Tetap',
                'alamat' => 'Jl. Damai No. 8, Desa Makmur',
            ],
            [
                'nik' => '1234567890123461',
                'nama_lengkap' => 'Ahmad Pending',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '1988-12-05',
                'agama' => 'Islam',
                'pekerjaan' => 'Guru',
                'status_perkawinan' => 'Belum Kawin',
                'status_penduduk' => 'Tetap',
                'alamat' => 'Jl. Pending No. 3, Desa Makmur',
            ],
        ];

        // Insert Penduduk data first
        foreach ($pendudukData as $data) {
            Penduduk::updateOrCreate(
                ['nik' => $data['nik']],
                $data
            );
        }

        // Now create users
        // 1. ADMIN USER
        $admin = User::updateOrCreate(
            ['email' => 'admin@sipades.com'],
            [
                'name' => 'Administrator SIPADES',
                'email' => 'admin@sipades.com',
                'password' => Hash::make('admin123'),
                'nik' => '1234567890123456',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // 2. LURAH USER
        $lurah = User::updateOrCreate(
            ['email' => 'lurah@sipades.com'],
            [
                'name' => 'Lurah Desa Makmur',
                'email' => 'lurah@sipades.com',
                'password' => Hash::make('lurah123'),
                'nik' => '1234567890123457',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        if (!$lurah->hasRole('lurah')) {
            $lurah->assignRole('lurah');
        }

        // 3. PETUGAS USER
        $petugas = User::updateOrCreate(
            ['email' => 'petugas@sipades.com'],
            [
                'name' => 'Petugas Administrasi',
                'email' => 'petugas@sipades.com',
                'password' => Hash::make('petugas123'),
                'nik' => '1234567890123458',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        if (!$petugas->hasRole('petugas')) {
            $petugas->assignRole('petugas');
        }

        // 4. WARGA/PENDUDUK USER 1 (APPROVED)
        $warga1 = User::updateOrCreate(
            ['email' => 'warga1@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'email' => 'warga1@gmail.com',
                'password' => Hash::make('warga123'),
                'nik' => '1234567890123459',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        if (!$warga1->hasRole('warga')) {
            $warga1->assignRole('warga');
        }

        // 5. WARGA/PENDUDUK USER 2 (APPROVED)
        $warga2 = User::updateOrCreate(
            ['email' => 'warga2@gmail.com'],
            [
                'name' => 'Siti Aminah',
                'email' => 'warga2@gmail.com',
                'password' => Hash::make('warga123'),
                'nik' => '1234567890123460',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        if (!$warga2->hasRole('warga')) {
            $warga2->assignRole('warga');
        }

        // 6. WARGA PENDING (For testing approval)
        $wargaPending = User::updateOrCreate(
            ['email' => 'pending@gmail.com'],
            [
                'name' => 'Ahmad Pending',
                'email' => 'pending@gmail.com',
                'password' => Hash::make('pending123'),
                'nik' => '1234567890123461',
                'is_active' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$wargaPending->hasRole('warga')) {
            $wargaPending->assignRole('warga');
        }

        $this->command->info('Demo users created successfully!');
        $this->command->info('');
        $this->command->info('=== LOGIN CREDENTIALS ===');
        $this->command->info('Admin: admin@sipades.com / admin123');
        $this->command->info('Lurah: lurah@sipades.com / lurah123');
        $this->command->info('Petugas: petugas@sipades.com / petugas123');
        $this->command->info('Warga 1: warga1@gmail.com / warga123');
        $this->command->info('Warga 2: warga2@gmail.com / warga123');
        $this->command->info('Pending: pending@gmail.com / pending123 (for testing approval)');
        $this->command->info('');
    }
}
