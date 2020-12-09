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
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use App\Http\Livewire\Connect\Profile\UpdateCurrentProfile;
use App\Models\Profile;

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
})->name('home');

Route::get('/@{tag}/{active_view?}', [ProfileController::class, 'show'])->name('profile.visit');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/@{profile}/follow', function ($profile) {
        return redirect("@/{$profile}/");
    });

    /*Route::get('/{user}/{profile}', [UserProfileController::class, 'show'])
    ->middleware('can:update,profile')
    ->name('profile.edit');*/

    Route::get('/{user}/@{tag}', UpdateCurrentProfile::class)
        ->name('current-profile.edit');

    Route::get('/account.me/{active_action?}/', UserDashboard::class)->name('dashboard');
    Route::middleware(['can:own-businesses'])->group(function () {
        Route::get('/business/@{tag}/{business}/{active_action?}/', BusinessDashboard::class)
            ->middleware('can:update-business,business')
            ->name('business.dashboard');

        Route::get('/business/@{tag}/{business}/products/{active_product?}/', BusinessProductList::class)
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