<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run()
    {
        // Clear cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Hapus data yang ada
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage-users',
            'manage-penduduk',
            'manage-surat',
            'validate-surat',
            'manage-pengaduan',
            'manage-informasi',
            'view-reports',
            'create-surat',
            'create-pengaduan',
            'view-own-surat',
            'view-own-pengaduan',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $lurahRole = Role::create(['name' => 'lurah']);
        $lurahRole->givePermissionTo([
            'validate-surat',
            'view-reports',
            'manage-surat'
        ]);

        $petugasRole = Role::create(['name' => 'petugas']);
        $petugasRole->givePermissionTo([
            'manage-surat',
            'validate-surat',
            'manage-penduduk',
            'manage-pengaduan',
            'manage-informasi',
            'view-reports'
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'create-surat',
            'view-own-surat',
            'create-pengaduan',
            'view-own-pengaduan'
        ]);
    }
}
