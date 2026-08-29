<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('tracking_method', 20)->nullable()->default('none')->after('meta_keywords');
        });

        // GTM was the only active integration before this selector existed.
        DB::table('site_settings')
            ->whereNotNull('gtm_container_id')
            ->where('gtm_container_id', '!=', '')
            ->update(['tracking_method' => 'gtm']);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn('tracking_method');
        });
    }
};
