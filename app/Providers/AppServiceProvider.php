<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 👇 تم تعديل المسار الصحيح للحزمة هنا (Bezhansalleh)
use Bezhansalleh\FilamentLanguageSwitch\LanguageSwitch;

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
        // 👇 إعداد تبديل اللغات للوحة التحكم (عربي وإنجليزي)
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en']) // اللغات المتاحة للتبديل
                ->labels([
                    'ar' => 'العربية',
                    'en' => 'English',
                ]);
        });
    }
}