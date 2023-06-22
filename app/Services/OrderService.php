<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public static function store(array $data): Order{
        $order = Order::create($data);
        return $order;
    }
}
