<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

            View::composer('*', function ($view) {
        $siteSetting = null;

        if (\Schema::hasTable('site_settings')) {
            $siteSetting = SiteSetting::first();
        }

        $view->with('siteSetting', $siteSetting);
    });
        View::composer('partials.header', function ($view): void {
            $activeCategories = collect();
            $siteSetting = null;

            if (Schema::hasTable('categories') && Schema::hasTable('products')) {
                $activeCategories = Category::query()
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->whereHas('products', function ($query): void {
                        $query->where('is_active', true)->whereNull('deleted_at');
                    })
                    ->with(['products' => function ($query): void {
                        $query->where('is_active', true)->whereNull('deleted_at')->orderByDesc('is_featured')->orderBy('sort_order')->latest();
                    }])
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get();
            }

            if (Schema::hasTable('site_settings')) {
                $siteSetting = SiteSetting::query()->first();
            }

            $view->with('activeCategoriesMenu', $activeCategories);
            $view->with('siteSetting', $siteSetting);
        });


        View::composer('layouts.app', function ($view): void {
            $metaTitle = null;
            $metaDescription = null;

            if (Schema::hasTable('site_settings')) {
                $setting = SiteSetting::query()->first();
                $metaTitle = $setting?->meta_title ?: $setting?->site_name;
                $metaDescription = $setting?->meta_description;
            }

            $view->with('metaTitle', $metaTitle);
            $view->with('metaDescription', $metaDescription);
        });


        View::composer(['layouts.admin', 'layouts.admin.sidebar', 'layouts.admin.header', 'admin.dashboard'], function ($view): void {
            $siteSetting = null;

            if (Schema::hasTable('site_settings')) {
                $siteSetting = SiteSetting::query()->first();
            }

            $view->with('siteSetting', $siteSetting);
        });

        View::composer('partials.footer', function ($view): void {
            $siteSetting = null;

            if (Schema::hasTable('site_settings')) {
                $siteSetting = SiteSetting::query()->first();
            }

            $view->with('siteSetting', $siteSetting);
        });
    }
}
