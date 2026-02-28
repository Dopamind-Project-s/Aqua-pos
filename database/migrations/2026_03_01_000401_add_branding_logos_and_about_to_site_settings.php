<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('primary_logo')->nullable()->after('site_name');
            $table->string('secondary_logo')->nullable()->after('primary_logo');
            $table->text('about_site_paragraph')->nullable()->after('footer_company_description');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'primary_logo',
                'secondary_logo',
                'about_site_paragraph',
            ]);
        });
    }
};
