<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\Order;

class OrderService
{
    public static function store(array $data): Order{

        // check if auth user is an admin and custom user id exists on request data
        if (auth()->user()->hasRole('admin') && isset($data['custom_user_id'])){
            // auth user is an admin and this order is being created for normal user
            $data['user_id'] = $data['custom_user_id'];
        }
        else{
            $data['user_id'] = auth()->id();
        }

        // set other default values
        $order['price'] = MenuItem::query()->find($data['menu_item_id'])->first()->price * $data['quantity'];

        $order = Order::create($data);
        return $order;
    }

    public static function update(Order $order, array $data): Order{
        $order->update($data);
        return $order;
    }
}
