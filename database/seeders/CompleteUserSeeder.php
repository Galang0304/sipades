<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CompleteUserSeeder extends Seeder
{
    public function run()
    {
        // Create user role if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        // Create 3 pending users with complete penduduk data
        $usersData = [
            [
                'penduduk' => [
                    'nik' => '6371000101010001',
                    'nama_lengkap' => 'Budi Santoso',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '1990-01-01',
                    'alamat' => 'Jl. Merdeka No. 123, RT 01/RW 01',
                    'agama' => 'Islam',
                    'jenis_kelamin' => 'Laki-laki',
                    'status_perkawinan' => 'Belum Kawin',
                    'pekerjaan' => 'Karyawan Swasta',
                    'status_penduduk' => 'Tetap',
                ],
                'user' => [
                    'name' => 'Budi Santoso',
                    'email' => 'budi.santoso@gmail.com',
                    'password' => Hash::make('password123'),
                    'is_active' => false,
                    'is_pending' => true,
                ]
            ],
            [
                'penduduk' => [
                    'nik' => '6371000202020002',
                    'nama_lengkap' => 'Siti Nurhaliza',
                    'tempat_lahir' => 'Bandung',
                    'tanggal_lahir' => '1992-02-15',
                    'alamat' => 'Jl. Sudirman No. 456, RT 02/RW 02',
                    'agama' => 'Islam',
                    'jenis_kelamin' => 'Perempuan',
                    'status_perkawinan' => 'Kawin',
                    'pekerjaan' => 'Guru',
                    'status_penduduk' => 'Tetap',
                ],
                'user' => [
                    'name' => 'Siti Nurhaliza',
                    'email' => 'siti.nurhaliza@gmail.com',
                    'password' => Hash::make('password123'),
                    'is_active' => false,
                    'is_pending' => true,
                ]
            ],
            [
                'penduduk' => [
                    'nik' => '6371000303030003',
                    'nama_lengkap' => 'Ahmad Hidayat',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '1988-12-25',
                    'alamat' => 'Jl. Gatot Subroto No. 789, RT 03/RW 03',
                    'agama' => 'Islam',
                    'jenis_kelamin' => 'Laki-laki',
                    'status_perkawinan' => 'Kawin',
                    'pekerjaan' => 'Wiraswasta',
                    'status_penduduk' => 'Sementara',
                ],
                'user' => [
                    'name' => 'Ahmad Hidayat',
                    'email' => 'ahmad.hidayat@gmail.com',
                    'password' => Hash::make('password123'),
                    'is_active' => false,
                    'is_pending' => true,
                ]
            ]
        ];
        
        foreach ($usersData as $data) {
            // Create penduduk first
            $penduduk = Penduduk::create($data['penduduk']);
            echo "Created penduduk: {$penduduk->nama_lengkap} (NIK: {$penduduk->nik})\n";
            
            // Add NIK to user data
            $data['user']['nik'] = $penduduk->nik;
            
            // Create user
            $user = User::create($data['user']);
            
            // Assign user role
            $user->assignRole('user');
            
            echo "Created pending user: {$user->name} ({$user->email})\n";
        }
        
        echo "\nSuccessfully created 3 pending users with complete data for approval testing!\n";
        echo "Login credentials: password123\n";
    }
}
