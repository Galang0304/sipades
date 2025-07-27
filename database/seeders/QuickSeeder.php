<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class QuickSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        Permission::truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create roles first
        $roles = ['admin', 'lurah', 'petugas', 'warga'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create users with roles
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@sipades.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Lurah Desa',
                'email' => 'lurah@sipades.com',
                'password' => Hash::make('password'),
                'role' => 'lurah'
            ],
            [
                'name' => 'Petugas Desa',
                'email' => 'petugas@sipades.com',
                'password' => Hash::make('password'),
                'role' => 'petugas'
            ],
            [
                'name' => 'Warga Desa',
                'email' => 'warga@sipades.com',
                'password' => Hash::make('password'),
                'role' => 'warga'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'is_active' => true
                ]
            );

            // Assign role
            $user->assignRole($userData['role']);
        }

        $this->command->info('Quick seeder completed successfully!');
    }
}
