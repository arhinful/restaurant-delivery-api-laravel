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
 * @group Menu Items
 */
class MenuItemController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'update', 'delete']);
        $this->authorizeResource(MenuItem::class, 'item');
    }

    /**
     * Fetch Menus.
     * Filter: /menu-items?filter[name]=kofibusy lounge [can be filtered by name and or price and or restaurant.id].
     * Sort: /menu-items?sort=name(Ascending) or -name, price, -price,
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\MenuItem paginate=15
     */
    public function index(): JsonResponse{
        $menu_items = QueryBuilder::for(MenuItem::class)
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
        $menu_items = MenuItemResource::collection($menu_items)->response()->getData(true);
        return $this->successReadCollection($menu_items);
    }

    /**
     * @authenticated
     * @header Authorization Bearer
     * Create New Menu Item.
     * @apiResourceModel App\Models\MenuItem
     */
    #[ResponseFromApiResource(MenuItemResource::class, MenuItem::class, 201)]
    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $menu_item = MenuItemService::store($request->validated());
            $menu_item = MenuItemResource::make($menu_item);
            return $this->successCreated($menu_item);
        } catch (\Exception $exception){
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Fetch Single Menu Item.
     * @apiResource App\Http\Resources\MenuItemResource
     * @apiResourceModel App\Models\MenuItem
     */
    public function view(MenuItem $item){
        $item = MenuItemResource::make($item);
        return $this->successRead($item);
    }
}
