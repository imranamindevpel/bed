<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'booking-list',
            'booking-create',
            'booking-edit',
            'booking-delete',
            'agent-list',
            'agent-create',
            'agent-edit',
            'agent-delete',
            'transaction-list',
            'transaction-create',
            'transaction-edit',
            'transaction-delete',
        ];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
