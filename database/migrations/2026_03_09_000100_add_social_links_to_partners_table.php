<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('apply_url')->nullable()->after('website_url');
            $table->string('facebook_url')->nullable()->after('apply_url');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('twitter_url')->nullable()->after('linkedin_url');
            $table->string('youtube_url')->nullable()->after('twitter_url');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'apply_url',
                'facebook_url',
                'instagram_url',
                'linkedin_url',
                'twitter_url',
                'youtube_url',
            ]);
        });
    }
};
