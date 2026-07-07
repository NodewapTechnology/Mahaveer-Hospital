<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;
use App\Models\ContactDetail;
use App\Models\SocialLink;
use App\Models\SeoSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('frontend.*', function ($view) {
            $view->with([
                'siteSettings' => WebsiteSetting::first(),
                'siteContact' => ContactDetail::first(),
                'siteSocials' => SocialLink::where('is_active', true)->orderBy('sort')->get(),
            ]);
        });

        View::composer('frontend.*', function ($view) {
            $data = $view->getData();
            if (!isset($data['seo'])) {
                $pageKey = $view->getName() ? str_replace('frontend.', '', $view->getName()) : 'home';
                $view->with('seo', SeoSetting::where('page_key', $pageKey)->first());
            }
        });
    }
}
