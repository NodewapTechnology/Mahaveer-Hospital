<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('recaptcha_site_key')->nullable()->after('accent_color');
            $table->string('recaptcha_secret_key')->nullable()->after('recaptcha_site_key');
            $table->string('notify_email')->nullable()->after('recaptcha_secret_key');
        });
    }
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['recaptcha_site_key', 'recaptcha_secret_key', 'notify_email']);
        });
    }
};
