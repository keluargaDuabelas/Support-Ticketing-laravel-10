<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::firstOrCreate(
            ['name' => 'respond', 'guard_name' => 'web']
        );

        // Temukan atau buat peran super_admin
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // Berikan izin ke peran super_admin
        $role->givePermissionTo($permission);
    }
}
