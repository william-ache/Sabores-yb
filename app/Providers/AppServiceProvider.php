<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        // Compartir el nombre de la app globalmente
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $appName = \App\Models\Setting::get('app_name', 'Sabores Y&B');
                $view->with('appName', $appName);
                $view->with('instagramUrl', \App\Models\Setting::get('instagram_url', ''));
                $view->with('tiktokUrl', \App\Models\Setting::get('tiktok_url', ''));
                $view->with('facebookUrl', \App\Models\Setting::get('facebook_url', ''));
                $view->with('youtubeUrl', \App\Models\Setting::get('youtube_url', ''));
                $view->with('twitterUrl', \App\Models\Setting::get('twitter_url', ''));
                $view->with('telegramUrl', \App\Models\Setting::get('telegram_url', ''));
                $view->with('whatsappNumber', \App\Models\Setting::get('whatsapp_number', ''));
            } catch (\Exception $e) {
                $view->with('appName', 'Sabores Y&B');
                $view->with('whatsappNumber', '');
            }
        });
    }
}
