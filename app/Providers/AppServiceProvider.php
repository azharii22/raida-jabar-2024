<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
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
        try {
            $settings = Setting::all();
            foreach ($settings as $setting) {
                config(['settings.' . $setting->key => $setting->value]);
            }
            config(['settings_array.model_types_plural' => ['tags' => ucfirst(config('settings.tags_label_plural')), 'documents' => ucfirst(config('settings.document_label_plural')), 'files' => ucfirst(config('settings.file_label_plural'))]]);
        } catch (\Exception $e) {
        }

        // Schema::defaultStringLength(191);
        // Setting::chargeConfig();

    }
    // public function boot(): void
    // {
    //     Setting::chargeConfig();
    // }
}
