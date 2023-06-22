<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restaurant\StoreRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Restaurants
 */
class RestaurantController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store']);
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    /**
     * Fetch Restaurants.
     * Filter: /restaurants?filter[name]=kofibusy lounge [can be filtered by name and location].
     * Sort: /restaurants?sort=name(Ascending) or restaurants?sort=-name (Descending)
     * [can be ordered by name and location].
     * @apiResource App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant
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
     * @authenticated
     * @header Authorization Bearer
     * Create New Restaurants.
     * @apiResource App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant
     */
    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $restaurant = RestaurantService::store($request->validated());
            $restaurant = RestaurantResource::make($restaurant);
            DB::commit();
            return $this->successCreated($restaurant);
        } catch (\Exception $exception){
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
