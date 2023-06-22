<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuItem\StoreRequest;
use App\Http\Resources\MenuItemResource;
use App\Http\Resources\RestaurantResource;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Services\MenuItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Menus
 */
class MenuItemController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'update', 'delete']);
        $this->authorizeResource(MenuItem::class, 'menu');
    }

    /**
     * Fetch Menus.
     * Filter: /menus?filter[name]=kofibusy lounge [can be filtered by name and or price and or restaurant.id].
     * Sort: /menus?sort=name(Ascending) or -name, price, -price,
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Menu paginate=15
     */
    public function index(): JsonResponse{
        $menus = QueryBuilder::for(MenuItem::class)
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
        $menus = MenuItemResource::collection($menus)->response()->getData(true);
        return $this->successReadCollection($menus);
    }

    /**
     * @authenticated
     * @header Authorization Bearer
     * Create New Menu.
     * @apiResourceModel App\Models\Menu
     */
    #[ResponseFromApiResource(MenuItemResource::class, MenuItem::class, 201)]
    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $menu = MenuItemService::store($request->validated());
            $menu = MenuItemResource::make($menu);
            return $this->successCreated($menu);
        } catch (\Exception $exception){
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
