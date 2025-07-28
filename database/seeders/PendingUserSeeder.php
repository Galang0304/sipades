<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class PendingUserSeeder extends Seeder
{
    public function run()
    {
        // Create user role if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        // Data untuk 3 akun pending
        $pendingUsers = [
            [
                'user' => [
                    'name' => 'Budi Santoso',
                    'email' => 'budi.santoso@gmail.com',
                    'password' => Hash::make('password123'),
                    'nik' => '6371000101010001',
                    'is_active' => false,
                    'is_pending' => true,
                ],
                'penduduk' => [
                    'nik' => '6371000101010001',
                    'nama_lengkap' => 'Budi Santoso',
                    'tempat_lahir' => 'Banjarmasin',
                    'tanggal_lahir' => '1990-01-01',
                    'alamat' => 'Jl. Sungai Andai No. 123, RT 01, RW 02',
                    'agama' => 'Islam',
                    'jenis_kelamin' => 'Laki-laki',
                    'status_perkawinan' => 'Kawin',
                    'pekerjaan' => 'Pegawai Swasta',
                    'status_penduduk' => 'penduduk_tetap',
                    'rt' => '01',
                    'rw' => '02',
                    'no_tlp' => '081234567890'
                ]
            ],
            [
                'user' => [
                    'name' => 'Siti Nurhaliza',
                    'email' => 'siti.nurhaliza@gmail.com',
                    'password' => Hash::make('password123'),
                    'nik' => '6371000202020002',
                    'is_active' => false,
                    'is_pending' => true,
                ],
                'penduduk' => [
                    'nik' => '6371000202020002',
                    'nama_lengkap' => 'Siti Nurhaliza',
                    'tempat_lahir' => 'Martapura',
                    'tanggal_lahir' => '1992-05-15',
                    'alamat' => 'Jl. Ahmad Yani No. 456, RT 03, RW 01',
                    'agama' => 'Islam',
                    'jenis_kelamin' => 'Perempuan',
                    'status_perkawinan' => 'Belum Kawin',
                    'pekerjaan' => 'Guru',
                    'status_penduduk' => 'penduduk_tetap',
                    'rt' => '03',
                    'rw' => '01',
                    'no_tlp' => '081234567891'
                ]
            ],
            [
                'user' => [
                    'name' => 'Ahmad Hidayat',
                    'email' => 'ahmad.hidayat@gmail.com',
                    'password' => Hash::make('password123'),
                    'nik' => '6371000303030003',
                    'is_active' => false,
                    'is_pending' => true,
                ],
                'penduduk' => [
                    'nik' => '6371000303030003',
                    'nama_lengkap' => 'Ahmad Hidayat',
                    'tempat_lahir' => 'Banjarbaru',
                    'tanggal_lahir' => '1988-12-20',
                    'alamat' => 'Jl. Veteran No. 789, RT 02, RW 03',
                    'agama' => 'Islam',
                    'jenis_kelamin' => 'Laki-laki',
                    'status_perkawinan' => 'Kawin',
                    'pekerjaan' => 'Wiraswasta',
                    'status_penduduk' => 'pindahan',
                    'rt' => '02',
                    'rw' => '03',
                    'no_tlp' => '081234567892'
                ]
            ]
        ];
        
        foreach ($pendingUsers as $data) {
            // Create penduduk first
            $penduduk = Penduduk::create($data['penduduk']);
            
            // Create user
            $user = User::create($data['user']);
            
            // Assign user role
            $user->assignRole('user');
            
            echo "Created pending user: {$user->name} ({$user->email})\n";
        }
        
        echo "Successfully created 3 pending users for approval testing!\n";
    }
}
