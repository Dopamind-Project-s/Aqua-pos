<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('partials.header', function ($view): void {
            $activeCategories = collect();

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

            $view->with('activeCategoriesMenu', $activeCategories);
        });
    }
}
