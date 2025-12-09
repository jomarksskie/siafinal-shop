<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $custRole  = Role::firstOrCreate(['name' => 'customer']);

    $admin = User::firstOrCreate(
        ['email' => 'admin@demo.com'],
        ['name' => 'Admin', 'password' => Hash::make('password')]
    );
    $admin->assignRole($adminRole);
}
}
