<?php

use App\Http\Controllers\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('menu')->group(function (){
    Route::apiResource('items', MenuItemController::class)->parameters('tem');
});

