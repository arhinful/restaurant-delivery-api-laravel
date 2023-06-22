<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Scribe;
use Symfony\Component\HttpFoundation\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        if (class_exists(\Knuckles\Scribe\Scribe::class)) {
//            Scribe::beforeResponseCall(function (Request $request, ExtractedEndpointData $endpointData) {
//                $token = User::first()->api_token;
//                $request->headers->add(["Authorization" => "Bearer $token"]);
//            });
//        }
    }
}
