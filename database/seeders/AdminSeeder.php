<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create regular admin
        Admin::create([
            'name' => 'John Admin',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create editor
        Admin::create([
            'name' => 'Jane Editor',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create moderator
        Admin::create([
            'name' => 'Mike Moderator',
            'email' => 'mike@example.com',
            'password' => Hash::make('password123'),
            'role' => 'moderator',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
