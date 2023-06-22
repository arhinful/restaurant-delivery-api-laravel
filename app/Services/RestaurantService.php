<?php

namespace App\Services;

use App\Models\Restaurant;

class RestaurantService
{
    public static function store(array $data): Restaurant{
        $restaurant = Restaurant::create($data);
        return $restaurant;
    }

    public static function update(Restaurant $restaurant, array $data): Restaurant{
        $restaurant->update($data);
        return $restaurant;
    }
}
