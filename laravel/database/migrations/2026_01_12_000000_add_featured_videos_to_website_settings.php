<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('website_settings', 'instagram_video_url')) {
                $table->string('instagram_video_url')->nullable()->after('accent_color');
            }
            if (!Schema::hasColumn('website_settings', 'youtube_video_url')) {
                $table->string('youtube_video_url')->nullable()->after('instagram_video_url');
            }
        });
    }
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['instagram_video_url', 'youtube_video_url']);
        });
    }
};
