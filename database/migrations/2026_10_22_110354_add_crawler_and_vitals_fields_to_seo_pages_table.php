<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->unsignedInteger('images_missing_alt')->default(0)->after('image_count');
            $table->float('ttfb_ms')->nullable()->after('performance_score');
            $table->float('page_weight_kb')->nullable()->after('ttfb_ms');
            $table->float('load_time_ms')->nullable()->after('page_weight_kb');
            $table->boolean('gzip_enabled')->default(false)->after('load_time_ms');
            $table->boolean('ssl_valid')->default(true)->after('gzip_enabled');
            $table->unsignedSmallInteger('http_status')->default(200)->after('ssl_valid');
            $table->unsignedSmallInteger('reading_time_min')->default(1)->after('http_status');
            $table->json('links_data')->nullable()->after('reading_time_min');
            $table->json('core_web_vitals')->nullable()->after('links_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->dropColumn([
                'images_missing_alt',
                'ttfb_ms',
                'page_weight_kb',
                'load_time_ms',
                'gzip_enabled',
                'ssl_valid',
                'http_status',
                'reading_time_min',
                'links_data',
                'core_web_vitals',
            ]);
        });
    }
};
