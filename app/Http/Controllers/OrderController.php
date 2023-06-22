<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Orders
 */
class OrderController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'update', 'destroy']);
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Fetch Orders.
     * Filter: /orders?filter[location]=sunyani [can be filtered by location and or user.id, and or menuItem.id
     * and or menuItem.restaurant.id].
     * Sort: /orders?sort=name(Ascending) or restaurants?sort=-name (Descending)
     * [can be ordered by name and location].
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant paginate=15
     */
    public function index(): JsonResponse{
        $orders = QueryBuilder::for(Order::class)
            ->allowedFilters([
                'location',
                AllowedFilter::partial('user.id'),
                AllowedFilter::partial('menuItem.id'),
                AllowedFilter::partial('menuItem.restaurant.id'),
            ])
            ->allowedSorts([
                'created_at',
                '-created_at',
                'location',
                '-location',
            ])
            ->paginate();
        $orders = OrderResource::collection($orders)->response()->getData(true);
        return $this->successCreated($orders);
    }
}
