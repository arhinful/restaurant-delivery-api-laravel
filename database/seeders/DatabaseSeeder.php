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
        // would throw an error if admin already exist or if admin has role already, so we put it in try catch block
        try {
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

            // assign admin role to user
            $admin->assignRole($role);
        }catch (\Exception $exception){}

         // seed restaurant
        $restaurants = Restaurant::factory(50)->create();

         // seed user
        $users = User::factory(50)->create()->each(function ($user) use ($restaurants){
            // after each user, loop through restaurant and create a menu item
            $restaurants->each(function ($restaurant) use ($user){

                MenuItem::factory(10)->create([
                    'restaurant_id' => $restaurant->id
                ])->each(function ($menuItem) use ($user){
                    // attach image to menu item
                    $faker = \Faker\Factory::create();
                    $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));
//                    $imageUrl = $faker->imageUrl(640,480, null, false);
                    $imageUrl = $faker->imageUrl();
                    $menuItem->addMediaFromUrl($imageUrl)->toMediaCollection('image');

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
