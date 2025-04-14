<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'الطلبات',
            'التقارير',
            'الحجوزات',
            'العملاء',
            'الدورات',
            'التصنيفات والخدمات',
            'الباقات',
            'الموظفين',
            'الإعدادات',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
