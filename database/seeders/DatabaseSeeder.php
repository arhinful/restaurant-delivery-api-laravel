<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
         $admin = \App\Models\User::create([
             'name' => 'Arhinful Emmanuel',
             'email' => 'kofibusy@gmail.com',
             'email_verified_at' => now(),
             'password' => '12345678',
             'remember_token' => Str::random(10),
         ]);

         // seed restaurant
        $restaurants = Restaurant::factory(50)->create();

         // seed user
        $users = User::factory(50)->create()->each(function ($user) use ($restaurants){
            // after each user, loop through restaurant and create a menu item
            $restaurants->each(function ($restaurant) use ($user){

                MenuItem::factory(10)->create([
                    'restaurant_id' => $restaurant->id
                ])->each(function ($menuItem) use ($user){

                    // after each menu item, create orders for this current user
                    $quantity = fake()->numberBetween(1, 6);

                    Order::factory(15)->create([
                        'menu_item_id' => $menuItem->id,
                        'user_id' => $user->id,
                        'quantity' => $quantity,
                        'price' => $quantity * $menuItem->price
                    ]);
                });
            });
        });

    }
}
