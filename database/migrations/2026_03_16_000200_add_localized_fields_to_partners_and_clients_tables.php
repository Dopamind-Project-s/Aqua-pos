<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_ar');
            $table->text('description_ar')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_ar');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_ar');
            $table->text('description')->nullable()->after('logo');
            $table->text('description_ar')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_ar');
        });

        DB::table('partners')->update([
            'name_en' => DB::raw('COALESCE(name_en, name)'),
            'description_en' => DB::raw('COALESCE(description_en, description)'),
        ]);

        DB::table('clients')->update([
            'name_en' => DB::raw('COALESCE(name_en, name)'),
            'description_en' => DB::raw('COALESCE(description_en, description)'),
        ]);
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'name_en', 'description_ar', 'description_en']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'name_en', 'description', 'description_ar', 'description_en']);
        });
    }
};
