<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ServiceController as PublicServiceController;
use App\Http\Controllers\Frontend\DoctorController as PublicDoctorController;
use App\Http\Controllers\Frontend\GalleryController as PublicGalleryController;
use App\Http\Controllers\Frontend\EventController as PublicEventController;
use App\Http\Controllers\Frontend\TestimonialController as PublicTestimonialController;
use App\Http\Controllers\Frontend\OfferController as PublicOfferController;
use App\Http\Controllers\Frontend\BlogController as PublicBlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ContactDetailController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Admin\FeaturedVideoController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\TranslationController;

// ----------------- Public / Frontend -----------------
Route::get('/lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'hi'])) session(['lang' => $lang]);
    return redirect(back()->getTargetUrl() ?: '/');
})->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [PublicServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [PublicServiceController::class, 'show'])->name('services.show');
Route::get('/doctors', [PublicDoctorController::class, 'index'])->name('doctors');
Route::get('/doctors/{slug}', [PublicDoctorController::class, 'show'])->name('doctors.show');
Route::get('/gallery', [PublicGalleryController::class, 'index'])->name('gallery');
Route::get('/events', [PublicEventController::class, 'index'])->name('events');
Route::get('/events/{slug}', [PublicEventController::class, 'show'])->name('events.show');
Route::get('/testimonials', [PublicTestimonialController::class, 'index'])->name('testimonials');
Route::get('/offers', [PublicOfferController::class, 'index'])->name('offers');
Route::get('/offers/{slug}', [PublicOfferController::class, 'show'])->name('offers.show');
Route::get('/blogs', [PublicBlogController::class, 'index'])->name('blogs');
Route::get('/blogs/{slug}', [PublicBlogController::class, 'show'])->name('blogs.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/enquiry', [ContactController::class, 'submit'])->name('enquiry.submit');

// ----------------- Admin -----------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::resource('banners', BannerController::class)->except(['show']);
        Route::get('about', [AdminAboutController::class, 'edit'])->name('about.edit');
        Route::put('about', [AdminAboutController::class, 'update'])->name('about.update');
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('doctors', DoctorController::class)->except(['show']);
        Route::resource('gallery', GalleryController::class)->except(['show'])->parameters(['gallery' => 'gallery']);
        Route::resource('events', EventController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('offers', OfferController::class)->except(['show']);
        Route::resource('blogs', BlogController::class)->except(['show']);
        Route::resource('faqs', FaqController::class)->except(['show']);
        Route::get('contact-details', [ContactDetailController::class, 'edit'])->name('contact-details.edit');
        Route::put('contact-details', [ContactDetailController::class, 'update'])->name('contact-details.update');
        Route::resource('social-links', SocialLinkController::class)->except(['show']);
        Route::resource('seo-settings', SeoSettingController::class)->except(['show', 'create', 'store']);
        Route::get('website-settings', [WebsiteSettingController::class, 'edit'])->name('website-settings.edit');
        Route::put('website-settings', [WebsiteSettingController::class, 'update'])->name('website-settings.update');

        Route::get('videos', [FeaturedVideoController::class, 'index'])->name('videos.index');
        Route::get('videos/create', [FeaturedVideoController::class, 'create'])->name('videos.create');
        Route::post('videos', [FeaturedVideoController::class, 'store'])->name('videos.store');
        Route::get('videos/{video}/edit', [FeaturedVideoController::class, 'edit'])->name('videos.edit');
        Route::put('videos/{video}', [FeaturedVideoController::class, 'update'])->name('videos.update');
        Route::delete('videos/{video}', [FeaturedVideoController::class, 'destroy'])->name('videos.destroy');
        Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('enquiries.show');
        Route::put('enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('enquiries.update');
        Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');

        Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::get('translations/create', [TranslationController::class, 'create'])->name('translations.create');
        Route::post('translations', [TranslationController::class, 'store'])->name('translations.store');
        Route::post('translations/seed-defaults', [TranslationController::class, 'seedDefaults'])->name('translations.seed');
        Route::get('translations/{translation}/edit', [TranslationController::class, 'edit'])->name('translations.edit');
        Route::put('translations/{translation}', [TranslationController::class, 'update'])->name('translations.update');
        Route::delete('translations/{translation}', [TranslationController::class, 'destroy'])->name('translations.destroy');
    });
});
