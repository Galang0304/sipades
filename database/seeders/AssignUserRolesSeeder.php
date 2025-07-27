<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AssignUserRolesSeeder extends Seeder
{
    public function run()
    {
        // Assign role admin to admin user
        $admin = User::where('email', 'admin@kuinsel.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }

        // Assign role user to all other users
        $users = User::where('email', '!=', 'admin@kuinsel.com')->get();
        foreach ($users as $user) {
            if (!$user->hasAnyRole()) {
                $user->assignRole('user');
            }
        }
    }
}
