<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الدور Admin إذا لم يكن موجودًا
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // جلب جميع الصلاحيات
        $permissions = Permission::all();

        // إسناد جميع الصلاحيات إلى دور admin
        $adminRole->syncPermissions($permissions);
    }
}
