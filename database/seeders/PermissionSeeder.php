<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'manage-users',
            'manage-penduduk', 
            'validate-surat',
            'manage-surat',
            'manage-pengaduan',
            'view-dashboard'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $lurahRole = Role::findByName('lurah');
        $petugasRole = Role::findByName('petugas');
        $wargaRole = Role::findByName('warga');

        // Admin gets all permissions
        $adminRole->givePermissionTo($permissions);

        // Lurah can validate surat and view dashboard
        $lurahRole->givePermissionTo(['validate-surat', 'view-dashboard']);

        // Petugas can manage penduduk, surat, pengaduan
        $petugasRole->givePermissionTo(['manage-penduduk', 'manage-surat', 'manage-pengaduan', 'view-dashboard']);

        // Warga can only view dashboard and submit surat/pengaduan
        $wargaRole->givePermissionTo(['view-dashboard']);

        $this->command->info('Permissions seeded successfully!');
    }
}
