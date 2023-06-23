<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
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
        $this->middleware(['auth'])->only(['', 'store', 'update', 'destroy']);
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Fetch Orders.
     *
     * <p>
     * If authenticated user is an admin, they will have access to all orders, on the other hand if authenticated
     * user is a normal user, only orders belonging to them will be returned
     * </p>
     *
     * <aside>
     * <h3>Filtering<h3>
     * Can be filtered by: [location], [user.id], [menuItem.id], [menuItem.restaurant.id]
     * </aside>
     *
     * <aside>
     * <h3>Sorting<h3>
     * Can sorted by: created_at, location
     * </aside>
     *
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant paginate=15
     */
    public function index(): JsonResponse{
        // check auth user type(admin or user)
        $isAdmin = auth()->user()->hasRole('admin');

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
            ])->when(!$isAdmin, function ($query){
                // authenticated user is not an admin, hence we will return
                // orders belonging to the authenticated user only
                return $query->where('user_id', auth()->id());
            }, function ($query){
                // default, we know authenticated user is an admin, hence we will return all orders
                return $query;
            })
            ->with(['menuItem', 'menuItem.restaurant', 'user'])
            ->paginate();
        $orders = OrderResource::collection($orders)->response()->getData(true);
        return $this->successCreated($orders);
    }

    /**
     * Create New Order.
     *
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
     *
     * If authenticated user is an admin, they will have access to any order, on the other hand if authenticated
     * user is a normal user, only order belonging to them will be accessible
     *
     * @apiResource App\Http\Resources\OrderResource
     * @apiResourceModel App\Models\Order
     */
    public function show(Order $order): JsonResponse{
        $order->loadMissing(['menuItem', 'menuItem.restaurant', 'user']);
        $order = OrderResource::make($order);
        return $this->successRead($order);
    }

    /**
     * Update Order.
     *
     * If authenticated user is an admin, they will have access to any order, on the other hand if authenticated
     * user is a normal user, only order belonging to them will be accessible
     *
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\Order
     */
    #[ResponseFromApiResource(OrderResource::class, Order::class, 202)]

    public function update(Order $order, UpdateRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $order = OrderService::update($order, $request->validated());
            $order->loadMissing(['menuItem', 'menuItem.restaurant', 'user']);
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
     *
     * If authenticated user is an admin, they will have access to any order, on the other hand if authenticated
     * user is a normal user, only order belonging to them will be accessible
     *
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
