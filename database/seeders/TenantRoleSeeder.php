<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TenantRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $gerente = Role::firstOrCreate(['name' => 'gerente']);
        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);

        // Define permissions
        $permissions = [
            'manage developments',
            'manage lots',
            'manage customers',
            'manage contracts',
            'manage payments',
            'view reports'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign permissions to roles
        $admin->syncPermissions(Permission::all());
        
        $gerente->syncPermissions([
            'manage lots',
            'manage customers',
            'manage contracts',
            'manage payments',
            'view reports'
        ]);

        $vendedor->syncPermissions([
            'manage customers',
            'manage contracts'
        ]);
        
        // Ensure the first user is an admin
        $user = \App\Models\User::first();
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
