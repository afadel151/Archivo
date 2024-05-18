<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => sha1('12345678'),
        ]);
        $SuperAdminRole = Role::create(['name' => 'super_admin']);
        $AdiminRole = Role::create(['name' => 'admin']);
        $StudentRole = Role::create(['name' => 'student']);
        $UploadFileP = Permission::create(['name' => 'upload files']);
        $DeleteFileP = Permission::create(['name' => 'delete files']);
        $CreateUsersP = Permission::create(['name' => 'create users']);
        $DeleteUsersP = Permission::create(['name' => 'delete users']);
        $UpdateUsersP = Permission::create(['name' => 'update users']);
        $AddSchoolyearP = Permission::create(['name' => 'add schoolyear']);
        $DeleteSchoolyearP = Permission::create(['name' => 'delete schoolyear']);
        $ViewFilesP = Permission::create(['name' => 'view files']);
        $SuperAdminRole->givePermissionTo([$CreateUsersP, $DeleteUsersP,$UpdateUsersP,$AddSchoolyearP,$DeleteSchoolyearP]);
        $AdiminRole->givePermissionTo([$UploadFileP, $DeleteFileP]);
        $StudentRole->givePermissionTo([$ViewFilesP]);
    }
}
