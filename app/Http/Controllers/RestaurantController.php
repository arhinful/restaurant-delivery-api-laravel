<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restaurant\StoreRequest;
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
        $this->middleware(['auth'])->only(['store']);
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    /**
     * Fetch Restaurants.
     * Filter: /restaurants?filter[name]=kofibusy lounge [can be filtered by name and location].
     * Sort: /restaurants?sort=name(Ascending) or restaurants?sort=-name (Descending)
     * [can be ordered by name and location].
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
     * @authenticated
     * @header Authorization Bearer
     * Create New Restaurants.
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
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Fetch Single Restaurants.
     * @apiResource App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant
     */
    public function show(Restaurant $restaurant){
        $restaurant = RestaurantResource::make($restaurant);
        return $this->successRead($restaurant);
    }
}