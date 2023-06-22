<?php

use App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::apiResource('menu-items', MenuItemController::class);
