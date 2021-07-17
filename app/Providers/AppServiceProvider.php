<?php

namespace App\Providers;

use App\Http\Resources\EpresenceResource;
use App\Http\Resources\GetDataResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        EpresenceResource::withoutWrapping();
        GetDataResource::withoutWrapping();
    }
}
