<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->decimal('map_latitude', 10, 7)->nullable()->after('apply_url');
            $table->decimal('map_longitude', 10, 7)->nullable()->after('map_latitude');
            $table->string('map_location_ar')->nullable()->after('map_longitude');
            $table->string('map_location_en')->nullable()->after('map_location_ar');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->foreignId('selected_partner_id')
                ->nullable()
                ->after('source_page')
                ->constrained('partners')
                ->nullOnDelete();
            $table->json('selected_partner_snapshot')->nullable()->after('selected_partner_id');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['selected_partner_id']);
            $table->dropColumn(['selected_partner_id', 'selected_partner_snapshot']);
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'map_latitude',
                'map_longitude',
                'map_location_ar',
                'map_location_en',
            ]);
        });
    }
};
