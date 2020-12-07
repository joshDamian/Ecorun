<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecentlyViewedController;
use App\Http\Livewire\General\User\UserDashboard;
use App\Http\Livewire\BuildAndManage\Business\BusinessDashboard;
use App\Http\Livewire\UserComponents\Cart\ViewCart;
use App\Http\Livewire\UserComponents\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\BuildAndManage\Business\BusinessProductList;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return (Auth::user()) ? view('auth-landing-page') : view('guest-landing-page');
});

Route::get('/{eco_tag}-{profile}/{active_view?}', [ProfileController::class, 'show'])->name('profile.visit');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/{eco_tag}-{profile}/follow', function ($eco_tag, $profile) {
        return redirect("/{$eco_tag}-{$profile}/");
    });

    Route::get('/{eco_tag}-{profile}/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::get('/account.me/{active_action?}/', UserDashboard::class)->name('dashboard');
    Route::middleware(['can:own-businesses'])->group(function () {
        Route::get('/business/{slug}/{business}/{active_action?}/', BusinessDashboard::class)
            ->middleware('can:update-business,business')
            ->name('business.dashboard');

        Route::get('/business/{slug}/{business}/products/{active_product?}/', BusinessProductList::class)
            ->middleware('can:update-business,business')
            ->name('business.products');
    });

    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
});

Route::get('/browsing-history', [RecentlyViewedController::class, 'index'])
    ->name('view-history.index');

Route::get('/shop/{slug}/{product}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('category.index');
Route::get('category/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

//Route::get('/cart', ViewCart::class);