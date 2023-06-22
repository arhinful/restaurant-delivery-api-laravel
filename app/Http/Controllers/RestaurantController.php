<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Restaurants
 */
class RestaurantController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only([]);
        $this->authorizeResource(Restaurant::class, 'restaurant');
    }

    /**
     * Fetch Restaurants.
     * Filter: /restaurants?filter[name]=kofibusy lounge
     * Sort: /restaurants?sort=name(Ascending) or restaurants?sort=-name (Descending)
     * @apiResource App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant
     */
    public function index(): JsonResponse{

        // use query builder to allow filtering and ordering
        $restaurants = QueryBuilder::for(Restaurant::class)
            ->allowedFilters([
                'name',
            ])
            ->allowedSorts([
                'name',
                '-name',
            ])->paginate();
        $restaurants = RestaurantResource::collection($restaurants)->response()->getData(true);
        return $this->successReadCollection($restaurants);
    }
}
