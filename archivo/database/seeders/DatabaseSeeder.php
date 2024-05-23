<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
        $this->call(SchoolYearSeeder::class);
        $this->call(BattalionSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(UserSeeder::class);
        // zmarvin@example.com
    }
}
