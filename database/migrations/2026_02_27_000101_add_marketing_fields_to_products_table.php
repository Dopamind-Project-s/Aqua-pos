<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->string('tagline')->nullable()->after('name');
            $table->json('key_features')->nullable()->after('description');
            $table->text('use_cases')->nullable()->after('key_features');
            $table->unsignedInteger('sort_order')->default(0)->after('price_note');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn(['tagline', 'key_features', 'use_cases', 'sort_order']);
        });
    }
};
