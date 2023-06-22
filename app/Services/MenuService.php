<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
    public static function store(array $data): Menu{
        $menu = Menu::create($data);
        return $menu;
    }
}
