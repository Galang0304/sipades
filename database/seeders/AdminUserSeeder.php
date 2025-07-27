<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat role admin jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Buat akun admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sipades.com',
            'password' => Hash::make('admin123'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Berikan role admin
        $admin->assignRole('admin');
    }
}
