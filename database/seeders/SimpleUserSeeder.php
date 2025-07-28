<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SimpleUserSeeder extends Seeder
{
    public function run()
    {
        // Create user role if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        // Create 3 pending users
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'password' => Hash::make('password123'),
                'nik' => '6371000101010001',
                'is_active' => false,
                'is_pending' => true,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@gmail.com',
                'password' => Hash::make('password123'),
                'nik' => '6371000202020002',
                'is_active' => false,
                'is_pending' => true,
            ],
            [
                'name' => 'Ahmad Hidayat',
                'email' => 'ahmad.hidayat@gmail.com',
                'password' => Hash::make('password123'),
                'nik' => '6371000303030003',
                'is_active' => false,
                'is_pending' => true,
            ]
        ];
        
        foreach ($users as $userData) {
            // Create user
            $user = User::create($userData);
            
            // Assign user role
            $user->assignRole('user');
            
            echo "Created pending user: {$user->name} ({$user->email})\n";
        }
        
        echo "Successfully created 3 pending users for approval testing!\n";
    }
}
