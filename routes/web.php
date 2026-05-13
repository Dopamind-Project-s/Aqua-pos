<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DynamicContentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryCatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\PublicMediaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/media/public/{path}', [PublicMediaController::class, 'show'])->where('path', '.*')->name('media.public');

Route::view('/about', 'about')->name('about');
Route::view('/feature', 'feature')->name('feature');

Route::get('/blog', [BlogController::class, 'blogIndex'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'blogShow'])->name('blog.show');

Route::get('/news', [BlogController::class, 'newsIndex'])->name('news');
Route::get('/news/{post:slug}', [BlogController::class, 'newsShow'])->name('news.show');

Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

Route::get('/team', [TeamController::class, 'index'])->name('team');

Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');

Route::get('/contact', [ServiceRequestController::class, 'contactForm'])->name('contact');
Route::get('/support', [ServiceRequestController::class, 'supportForm'])->name('support');
Route::get('/request-product-demo', [ServiceRequestController::class, 'demoForm'])->name('request-product-demo');

Route::post('/requests', [ServiceRequestController::class, 'store'])->name('requests.store');

Route::view('/not-found', '404')->name('not-found');

Route::get('/products', [ProductCatalogController::class, 'index'])->name('products');
Route::get('/products/{product:slug}', [ProductCatalogController::class, 'show'])->name('products.show');
Route::get('/categories/{category:slug}', [CategoryCatalogController::class, 'show'])->name('categories.show');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/index', [DashboardController::class, 'index'])->name('index');

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class)->whereNumber('category');
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->whereNumber('category')->name('categories.toggle-status');
        Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->whereNumber('category')->name('categories.force-delete');
        Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulk-action');

        /*
        |--------------------------------------------------------------------------
        | Products & Posts
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class);
        Route::resource('posts', PostController::class);

        /*
        |--------------------------------------------------------------------------
        | Partners
        |--------------------------------------------------------------------------
        */

        Route::resource('partners', AdminPartnerController::class)->except(['show']);
        Route::post('partners/{partner}/toggle-status', [AdminPartnerController::class, 'toggleStatus'])->name('partners.toggle-status');
        Route::post('partners/reorder', [AdminPartnerController::class, 'reorder'])->name('partners.reorder');

        Route::resource('clients', AdminClientController::class)->except(['show']);
        Route::post('clients/{client}/toggle-status', [AdminClientController::class, 'toggleStatus'])->name('clients.toggle-status');

        Route::resource('team-members', TeamMemberController::class)->except(['show']);
        Route::post('team-members/{teamMember}/toggle-status', [TeamMemberController::class, 'toggleStatus'])->name('team-members.toggle-status');
        Route::post('team-members/reorder', [TeamMemberController::class, 'reorder'])->name('team-members.reorder');

        /*
        |--------------------------------------------------------------------------
        | Requests
        |--------------------------------------------------------------------------
        */

        Route::get('requests', [AdminServiceRequestController::class, 'index'])->name('requests.index');
        Route::patch('requests/{serviceRequest}/status', [AdminServiceRequestController::class, 'updateStatus'])->name('requests.update-status');

        Route::prefix('cms')->name('cms.')->group(function () {
            Route::get('page', [DynamicContentController::class, 'index'])->name('index');
            Route::post('save', [DynamicContentController::class, 'save'])->name('save');
            Route::post('upload-image', [DynamicContentController::class, 'uploadImage'])->name('upload-image');
            Route::post('upload-video', [DynamicContentController::class, 'uploadVideo'])->name('upload-video');
        });

        Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

    });

});
