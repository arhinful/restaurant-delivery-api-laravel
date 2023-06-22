<?php

namespace App\Services;

use App\Models\Restaurant;

class RestaurantService
{
    public static function store(array $data): Restaurant{
        $restaurant = Restaurant::create($data);
        return $restaurant;
    }
}
