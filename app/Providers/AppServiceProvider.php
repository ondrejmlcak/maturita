<?php

namespace App\Providers;

use App\Models\League;
use App\Services\TransfermarktService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {

    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('leagues', League::all());
        });
    }
}
