<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table): void {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_ar');
            $table->text('description_ar')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_ar');
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('name_en')->nullable()->after('name_ar');
            $table->string('tagline_ar')->nullable()->after('tagline');
            $table->string('tagline_en')->nullable()->after('tagline_ar');
            $table->string('short_description_ar')->nullable()->after('short_description');
            $table->string('short_description_en')->nullable()->after('short_description_ar');
            $table->longText('description_ar')->nullable()->after('description');
            $table->longText('description_en')->nullable()->after('description_ar');
            $table->text('use_cases_ar')->nullable()->after('use_cases');
            $table->text('use_cases_en')->nullable()->after('use_cases_ar');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn([
                'name_ar',
                'name_en',
                'tagline_ar',
                'tagline_en',
                'short_description_ar',
                'short_description_en',
                'description_ar',
                'description_en',
                'use_cases_ar',
                'use_cases_en',
            ]);
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn([
                'name_ar',
                'name_en',
                'description_ar',
                'description_en',
            ]);
        });
    }
};
