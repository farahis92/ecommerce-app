<?php

namespace App\Providers;

use App\Services\ApiResponse;
use Carbon\Carbon;
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
        $this->app->singleton('ApiResponse', function() {
            return new ApiResponse();
        });
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        config(['app.locale' => 'en']);
        Carbon::setLocale('en');
        date_default_timezone_set('Asia/Jakarta');
    }
}
