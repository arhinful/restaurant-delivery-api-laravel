<?php

namespace App\Services;

use App\Models\MenuItem;

class MenuItemService
{
    public static function store(array $data): MenuItem{
        $menu = MenuItem::create($data);
        return $menu;
    }

    public static function update(MenuItem $item, array $data): MenuItem{
        $item->update($data);
        return $item;
    }
}
