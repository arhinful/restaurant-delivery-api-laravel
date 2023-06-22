<?php

namespace App\Http\Controllers;

use App\Models\Menu;

/**
 * @group Menus
 */
class MenuController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'update', 'delete']);
        $this->authorizeResource(Menu::class, 'menu');
    }
}
