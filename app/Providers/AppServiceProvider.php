<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];
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
        Carbon::setLocale(App::getLocale());
    }
}
