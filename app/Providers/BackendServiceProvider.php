<?php

namespace App\Providers;

use App\Contracts\ShiftRepositoryContract;
use App\Repository\ShiftRepository;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public $bindings = [
        ShiftRepositoryContract::class => ShiftRepository::class
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
