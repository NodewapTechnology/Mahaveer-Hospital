<?php
/**
 * These are DEFAULTS from .env. Actual runtime values are looked up from the
 * website_settings row in DB (see App\Http\Controllers\Frontend\ContactController).
 */
return [
    'site_key'   => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    'min_score'  => (float) env('RECAPTCHA_MIN_SCORE', 0.5),

    'notify_email' => env('ENQUIRY_NOTIFY_EMAIL'),
];
