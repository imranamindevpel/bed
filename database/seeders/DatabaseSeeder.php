<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\CreateAdminUserSeeder;
use Database\Seeders\BedSeeder;
use Database\Seeders\TenantSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(BedSeeder::class);
    }
}
