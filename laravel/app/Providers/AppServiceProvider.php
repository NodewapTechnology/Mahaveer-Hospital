<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\Models\WebsiteSetting;
use App\Models\ContactDetail;
use App\Models\SocialLink;
use App\Models\SeoSetting;
use App\Helpers\I18n;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Custom Blade directives for translations
        Blade::directive('t', function ($expression) {
            return "<?php echo e(\\App\\Helpers\\I18n::ui($expression)); ?>";
        });
        Blade::directive('tf', function ($expression) {
            // @tf($model, 'field') — translated field with fallback to English
            return "<?php echo e(\\App\\Helpers\\I18n::t($expression)); ?>";
        });
        Blade::directive('tfraw', function ($expression) {
            // Raw HTML translated
            return "<?php echo \\App\\Helpers\\I18n::t($expression); ?>";
        });

        View::composer('frontend.*', function ($view) {
            $view->with([
                'siteSettings' => WebsiteSetting::first(),
                'siteContact' => ContactDetail::first(),
                'siteSocials' => SocialLink::where('is_active', true)->orderBy('sort')->get(),
                'currentLang' => session('lang', 'en'),
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
