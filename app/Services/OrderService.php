<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public static function store(array $data): Order{

        // check if auth user is an admin and custom user id exists on request data
        if (auth()->user()->hasRole('admin') && isset($data['custom_user_id'])){
            // auth user is an admin and this order is being created for normal user
            $data['user_id'] = $data['custom_user_id'];
        }
        $order = Order::create($data);
        return $order;
    }
}
