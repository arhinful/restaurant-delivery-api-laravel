<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'update', 'destroy']);
        $this->authorizeResource(Order::class, 'order');
    }
}
