<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuItem\StoreRequest;
use App\Http\Requests\MenuItem\UpdateRequest;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
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
     * Create New Menu Item.
     * @authenticated
     * @header Authorization Bearer.
     * @apiResourceModel App\Models\MenuItem.
     */
    #[ResponseFromApiResource(MenuItemResource::class, MenuItem::class, 201)]
    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $menu_item = MenuItemService::store($request->validated());
            $menu_item = MenuItemResource::make($menu_item);
            DB::commit();
            return $this->successCreated($menu_item);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Fetch Single Menu Item.
     * @apiResource App\Http\Resources\MenuItemResource
     * @apiResourceModel App\Models\MenuItem
     */
    public function show(MenuItem $item): JsonResponse{
        $item = MenuItemResource::make($item);
        return $this->successRead($item);
    }

    /**
     * Update Menu Item.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\MenuItem
     */
    #[ResponseFromApiResource(MenuItemResource::class, MenuItem::class, 202)]
    public function update(MenuItem $item, UpdateRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $item = MenuItemService::update($item, $request->validated());
            $item = MenuItemResource::make($item);
            DB::commit();
            return $this->successUpdated($item);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }

    /**
     * Delete Menu Item.
     * @authenticated
     * @header Authorization Bearer
     * @apiResourceModel App\Models\MenuItem
     */
    public function destroy(MenuItem $item): JsonResponse{
        DB::beginTransaction();
        try {
            $item->delete();
            DB::commit();
            return $this->successDeleted();
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
