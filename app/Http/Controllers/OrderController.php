<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\RestaurantResource;
use App\Models\Order;
use App\Models\Restaurant;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
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

    /**
     * Create New Order.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\Order
     */
    #[ResponseFromApiResource(OrderResource::class, Order::class, 201)]

    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $order = OrderService::store($request->validated());
            $order = OrderResource::make($order);
            DB::commit();
            return $this->successCreated($order);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Fetch Single Order.
     * @apiResource App\Http\Resources\OrderResource
     * @apiResourceModel App\Models\Order
     */
    public function show(Order $order): JsonResponse{
        $order = OrderResource::make($order);
        return $this->successRead($order);
    }

    /**
     * Update Order.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\Order
     */
    #[ResponseFromApiResource(OrderResource::class, Order::class, 202)]

    public function update(Order $order, UpdateRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $order = OrderService::update($order, $request->validated());
            $order = OrderResource::make($order);
            DB::commit();
            return $this->successUpdated($order);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Delete Restaurant.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\Restaurant
     */
    public function destroy(Order $order): JsonResponse{
        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();
            return $this->successDeleted();
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
