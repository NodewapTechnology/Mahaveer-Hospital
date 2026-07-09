<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['banners','about_pages','services','doctors','testimonials','offers','events','blogs','faqs','contact_details','website_settings','gallery_items'] as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->json('translations')->nullable()->after('id');
            });
        }
        Schema::table('contact_details', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('emergency_phone');
        });
        Schema::table('website_settings', function (Blueprint $table) {
            $table->boolean('language_switch_enabled')->default(true)->after('accent_color');
        });
    }
    public function down(): void
    {
        foreach (['banners','about_pages','services','doctors','testimonials','offers','events','blogs','faqs','contact_details','website_settings','gallery_items'] as $t) {
            Schema::table($t, function (Blueprint $table) { $table->dropColumn('translations'); });
        }
        Schema::table('contact_details', function (Blueprint $table) { $table->dropColumn('whatsapp_number'); });
        Schema::table('website_settings', function (Blueprint $table) { $table->dropColumn('language_switch_enabled'); });
    }
};
