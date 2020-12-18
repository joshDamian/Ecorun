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
use App\Http\Livewire\Connect\Profile\UpdateProfile;
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

Route::get(
    '/',
    function () {
        return (Auth::user()) ? view('auth-landing-page') : view('guest-landing-page');
    }
)->name('home');

Route::get('/@{profile:tag}/{active_view?}', [ProfileController::class, 'show'])->name('profile.visit');

Route::middleware(['auth:sanctum', 'verified'])->group(
    function () {
        Route::put(
            '/guest/@{tag}/follow',
            function ($tag) {
                return redirect("@/{$tag}/");
            }
        )->name('guest.follow-profile');

        /*Route::get('/{user}/{profile}', [UserProfileController::class, 'show'])
        ->middleware('can:update,profile')
        ->name('profile.edit');*/

        Route::get('/{user}/@{profile:tag}/edit', UpdateProfile::class)
        ->name('profile.edit');

        Route::put('/{user}/current-profile/update', [ProfileController::class, 'updateCurrentProfile'])->name('current-profile.update');

        Route::get('/account.me/{active_action?}/', UserDashboard::class)->name('dashboard');
  
        Route::middleware(['can:own-businesses'])->group(
            function () {
                Route::get('/business/@{tag}/{business}/{action_route?}/{action_route_resource?}', BusinessDashboard::class)
                    ->middleware('can:update-business,business')
                    ->name('business.dashboard');

                Route::get(
                    '/business/@{tag}/{business}/products/{active_product?}/', function ($tag, $business, $active_product) {
                        return redirect(route('business.dashboard', ['business' => $business->id, 'action_route' => 'products', 'action_route_resource' => $active_product]));
                    }
                )
                     ->middleware('can:update-business,business')
                     ->name('business.products');
            }
        );

        Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
    }
);

Route::get('/browsing-history', [RecentlyViewedController::class, 'index'])
->name('view-history.index');

Route::get('/shop/{slug}/{product}', [ProductController::class, 'show'])
->name('product.show');

Route::get('/categories', [CategoryController::class, 'index'])
->name('category.index');
Route::get('category/{slug}', [CategoryController::class, 'show'])
->name('category.show');

//Route::get('/cart', ViewCart::class);
