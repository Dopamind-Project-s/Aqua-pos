<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('site_name')->nullable()->after('id');
            $table->string('meta_title')->nullable()->after('site_name');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');

            $table->string('facebook_url')->nullable()->after('meta_keywords');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('twitter_url')->nullable()->after('linkedin_url');
            $table->string('youtube_url')->nullable()->after('twitter_url');
            $table->string('tiktok_url')->nullable()->after('youtube_url');

            $table->string('whatsapp_number')->nullable()->after('tiktok_url');
            $table->text('google_map_embed')->nullable()->after('whatsapp_number');

            $table->string('hq_title')->nullable()->after('google_map_embed');
            $table->string('hq_address')->nullable()->after('hq_title');
            $table->string('info_email')->nullable()->after('hq_address');
            $table->string('support_email')->nullable()->after('info_email');
            $table->string('phone_primary')->nullable()->after('support_email');
            $table->string('phone_secondary')->nullable()->after('phone_primary');

            $table->string('footer_company_title')->nullable()->after('phone_secondary');
            $table->text('footer_company_description')->nullable()->after('footer_company_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn([
                'site_name',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'facebook_url',
                'instagram_url',
                'linkedin_url',
                'twitter_url',
                'youtube_url',
                'tiktok_url',
                'whatsapp_number',
                'google_map_embed',
                'hq_title',
                'hq_address',
                'info_email',
                'support_email',
                'phone_primary',
                'phone_secondary',
                'footer_company_title',
                'footer_company_description',
            ]);
        });
    }
};
