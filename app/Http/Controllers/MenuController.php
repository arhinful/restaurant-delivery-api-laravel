<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Menus
 */
class MenuController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'update', 'delete']);
        $this->authorizeResource(Menu::class, 'menu');
    }

    /**
     * Fetch Menus.
     * Filter: /restaurants?filter[name]=kofibusy lounge [can be filtered by name and or price and or restaurant.id].
     * Sort: /restaurants?sort=name(Ascending) or restaurants?sort=-name (Descending)
     * [can be ordered by name and location].
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Restaurant paginate=15
     */
    public function index(){
        $menus = QueryBuilder::for(Menu::class)
            ->allowedFilters([
                'name',
                'price',
                AllowedFilter::partial('restaurant.id')
            ])
            ->allowedSorts([
                'name',
                '-name',
                'price',
                '-price',
            ])
            ->paginate();
        $menus = MenuResource::collection($menus)->response()->getData(true);
        return $this->successReadCollection($menus);
    }
}
