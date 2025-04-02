<?php

namespace App\Providers;

use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Illuminate\Support\ServiceProvider;
use App\Providers\GoogleApiSocialiteProvider;
use Laravel\Socialite\Two\GoogleProvider;

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
        $socialite = $this->app->make(SocialiteFactory::class);
        $socialite->extend(
            'google_api',
            function ($app) use ($socialite) {
                $config = $app['config']['services.google_api'];
                return new GoogleProvider(
                    $app['request'],
                    $config['client_id'],
                    $config['client_secret'],
                    $config['redirect']
                );
            }
        );
    }
}
