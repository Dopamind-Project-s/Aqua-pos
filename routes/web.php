<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceRequestController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/service', 'service')->name('service');
Route::view('/appointment', 'appointment')->name('appointment');
Route::view('/feature', 'feature')->name('feature');
Route::get('/blog', [BlogController::class, 'blogIndex'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'blogShow'])->name('blog.show');
Route::get('/news', [BlogController::class, 'newsIndex'])->name('news');
Route::get('/news/{post:slug}', [BlogController::class, 'newsShow'])->name('news.show');
Route::view('/team', 'team')->name('team');
Route::view('/testimonial', 'testimonial')->name('testimonial');
Route::get('/contact', [ServiceRequestController::class, 'contactForm'])->name('contact');
Route::get('/support', [ServiceRequestController::class, 'supportForm'])->name('support');
Route::get('/request-product-demo', [ServiceRequestController::class, 'demoForm'])->name('request-product-demo');
Route::post('/requests', [ServiceRequestController::class, 'store'])->name('requests.store');
Route::view('/not-found', '404')->name('not-found');

Route::get('/products', function () {
    $products = Product::query()
        ->with(['category'])
        ->where('is_active', true)
        ->whereNull('deleted_at')
        ->whereHas('category', fn ($query) => $query->where('is_active', true)->whereNull('deleted_at'))
        ->latest()
        ->paginate(12);

    return view('products', compact('products'));
})->name('products');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::view('/index', 'admin.index')->name('index');
    Route::view('/ui-card', 'admin.ui-card')->name('ui-card');
    Route::view('/ui-forms', 'admin.ui-forms')->name('ui-forms');
    Route::view('/ui-buttons', 'admin.ui-buttons')->name('ui-buttons');
    Route::view('/ui-typography', 'admin.ui-typography')->name('ui-typography');
    Route::view('/ui-alerts', 'admin.ui-alerts')->name('ui-alerts');
    Route::view('/icon-tabler', 'admin.icon-tabler')->name('icon-tabler');
    Route::view('/sample-page', 'admin.sample-page')->name('sample-page');
    Route::view('/docs', 'admin.docs')->name('docs');
    Route::view('/discount-code', 'admin.discount-code')->name('discount-code');
    Route::view('/authentication-login', 'admin.authentication-login')->name('authentication-login');
    Route::view('/authentication-register', 'admin.authentication-register')->name('authentication-register');

    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');
    Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulk-action');

    Route::resource('products', ProductController::class);
    Route::resource('posts', PostController::class);
});
