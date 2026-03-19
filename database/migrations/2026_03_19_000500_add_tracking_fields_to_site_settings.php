<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('gtm_container_id')->nullable()->after('meta_keywords');
            $table->string('ga4_measurement_id')->nullable()->after('gtm_container_id');
            $table->string('google_ads_conversion_id')->nullable()->after('ga4_measurement_id');
            $table->string('google_ads_conversion_label')->nullable()->after('google_ads_conversion_id');
            $table->string('meta_pixel_id')->nullable()->after('google_ads_conversion_label');
            $table->string('google_site_verification')->nullable()->after('meta_pixel_id');
            $table->string('search_console_property')->nullable()->after('google_site_verification');
            $table->string('ms_clarity_project_id')->nullable()->after('search_console_property');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'gtm_container_id',
                'ga4_measurement_id',
                'google_ads_conversion_id',
                'google_ads_conversion_label',
                'meta_pixel_id',
                'google_site_verification',
                'search_console_property',
                'ms_clarity_project_id',
            ]);
        });
    }
};
