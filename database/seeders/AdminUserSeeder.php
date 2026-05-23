<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Delete old admin if exists (optional)
        User::where('email', 'dilangamora2@gmail.com')->delete();

        User::create([
            'name'     => 'Admin',
            'email'    => 'dilangamora2@gmail.com',
            'password' => Hash::make('password'),   // Default password = "password"
            'role'     => 'admin',
            'phone'    => '+94 72 372 2421',
            'status'   => 'active',
        ]);

        echo "✅ Admin user created successfully!\n";
        echo "Email: dilangamora2@gmail.com\n";
        echo "Password: password\n";
    }
}