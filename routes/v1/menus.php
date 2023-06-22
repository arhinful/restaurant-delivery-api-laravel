<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::apiResource('menus', MenuController::class);
