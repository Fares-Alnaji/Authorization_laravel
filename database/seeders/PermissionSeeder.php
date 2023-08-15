<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name' => 'Create-City', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Cities', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-City', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-City', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Admin', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-User', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Role', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Read-Cities', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Users', 'guard_name' => 'user']);

        /****************************** Admin ************************************* */

        Permission::create(['name' => 'Create-Category', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Categories', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Category', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Category', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-SubCategory', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-SubCategories', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-SubCategory', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-SubCategory', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Task', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Tasks', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Task', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Task', 'guard_name' => 'admin']);


        /****************************** User ************************************* */

        Permission::create(['name' => 'Read-Categories', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-SubCategories', 'guard_name' => 'user']);

        Permission::create(['name' => 'Create-Task', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Tasks', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Task', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Task', 'guard_name' => 'user']);
    }
}
