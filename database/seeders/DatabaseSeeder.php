<?php

namespace Database\Seeders;

use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Admin::where('email', 'admin@admin.com')->delete();
        Admin::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('Admin123')
        ]);

        $users = [
            [
                'name' => 'rasyid',
                'email' => 'rasyid@gmail.com',
                'password' => 'rasyid123'
            ],
            [
                'name' => 'alissa',
                'email' => 'alissa@gmail.com',
                'password' => 'alissa123'
            ],
            [
                'name' => 'faisal',
                'email' => 'faisal@gmail.com',
                'password' => 'faisal123',
                'image_path' => 'assets\images\faisal-profile.jpg'
            ],
        ];
        
        User::whereIn('email', array_column($users, 'email'))->delete();
        
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'image_path' => $user['image_path'] ?? null
            ]);
        }
    }
}
