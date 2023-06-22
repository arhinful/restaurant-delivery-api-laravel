<?php

namespace App\Http\Controllers;

use App\Http\Requests\Menu\StoreRequest;
use App\Http\Resources\MenuResource;
use App\Http\Resources\RestaurantResource;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
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
     * Filter: /menus?filter[name]=kofibusy lounge [can be filtered by name and or price and or restaurant.id].
     * Sort: /menus?sort=name(Ascending) or -name, price, -price,
     * @apiResourceCollection App\Http\Resources\RestaurantResource
     * @apiResourceModel App\Models\Menu paginate=15
     */
    public function index(): JsonResponse{
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

    /**
     * @authenticated
     * @header Authorization Bearer
     * Create New Menu.
     * @apiResourceModel App\Models\Menu
     */
    #[ResponseFromApiResource(MenuResource::class, Menu::class, 201)]
    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $menu = MenuService::store($request->validated());
            $menu = MenuResource::make($menu);
            return $this->successCreated($menu);
        } catch (\Exception $exception){
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
