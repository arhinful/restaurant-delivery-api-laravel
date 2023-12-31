<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restaurant\StoreRequest;
use App\Http\Requests\Restaurant\UpdateRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Restaurants
 */
class RestaurantController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'update', 'delete']);
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    /**
     * Fetch Restaurants.
     *
     * <aside>
     * <h3>Filtering<h3>
     * Can be filtered by: [name], [location].
     * </aside>
     *
     * <aside>
     * <h3>Sorting<h3>
     * Can sorted by: name, location
     * </aside>
     *
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant paginate=15
     */
    public function index(): JsonResponse{

        // use query builder to allow filtering and ordering
        $restaurants = QueryBuilder::for(Restaurant::class)
            ->allowedFilters([
                'name',
                'location',
            ])
            ->allowedSorts([
                'name',
                '-name',
                'location',
                '-location',
            ])->paginate();
        $restaurants = RestaurantResource::collection($restaurants)->response()->getData(true);
        return $this->successReadCollection($restaurants);
    }

    /**
     * Create New Restaurant.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\Restaurant
     */
    #[ResponseFromApiResource(RestaurantResource::class, Restaurant::class, 201)]
    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $restaurant = RestaurantService::store($request->validated());
            $restaurant = RestaurantResource::make($restaurant);
            DB::commit();
            return $this->successCreated($restaurant);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Fetch Single Restaurant.
     * @apiResource App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant
     */
    public function show(Restaurant $restaurant): JsonResponse{
        $restaurant = RestaurantResource::make($restaurant);
        return $this->successRead($restaurant);
    }

    /**
     * Update Restaurant.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\Restaurant
     */
    #[ResponseFromApiResource(RestaurantResource::class, Restaurant::class, 202)]
    public function update(Restaurant $restaurant, UpdateRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $restaurant = RestaurantService::update($restaurant, $request->validated());
            $restaurant = RestaurantResource::make($restaurant);
            DB::commit();
            return $this->successUpdated($restaurant);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Delete Order.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\Order
     */
    public function destroy(Restaurant $restaurant): JsonResponse{
        DB::beginTransaction();
        try {
            $restaurant->delete();
            DB::commit();
            return $this->successDeleted();
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
