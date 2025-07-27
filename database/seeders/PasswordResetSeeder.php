<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasswordResetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset semua password ke 'password'
        $users = [
            'admin@sipades.com',
            'lurah@sipades.com', 
            'petugas@sipades.com',
            'member@sipades.com'
        ];

        foreach ($users as $email) {
            $user = \App\Models\User::where('email', $email)->first();
            if ($user) {
                $user->password = \Illuminate\Support\Facades\Hash::make('password');
                $user->save();
                echo "Password {$user->name} ({$email}) direset ke: password" . PHP_EOL;
            }
        }
    }
}
