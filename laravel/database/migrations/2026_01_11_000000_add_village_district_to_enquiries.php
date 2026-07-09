<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('enquiries', 'village')) {
                $table->string('village')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('enquiries', 'district')) {
                $table->string('district')->nullable()->after('village');
            }
        });
    }
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn(['village', 'district']);
        });
    }
};
