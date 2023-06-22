<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create admin role
        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'sanctum'
        ]);

        // create admin user and assign admin role
         \App\Models\User::factory(1)->create()->each(function ($user){
             $user->assignRole('admin');
         });
    }
}
