<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecentlyViewedController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Enterprise\ManageEnterprise;
use App\Http\Livewire\UserComponents\Cart\ViewCart;
use App\Http\Livewire\UserComponents\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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

//Route::view('/', (dd(Auth::user())) ? 'auth-landing-page' : 'guest-landing-page');

Route::get('/timeline/{slug}/{profile}/{active_view?}', [ProfileController::class, 'show'])->name('timeline.show');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard/{active_action?}/', Dashboard::class)->name('dashboard');
    Route::middleware(['can:own-enterprise'])->group(function () {
        Route::get('/my-bss/{slug}/{enterprise}/{active_action?}/', ManageEnterprise::class)
            ->middleware('can:update-enterprise,enterprise')
            ->name('enterprise.dashboard');
    });

    Route::get('/timeline.me/{active_view?}/', function ($active_view = null) {
        $profile = Auth::user()->profile;
        return view('timeline.show', compact('profile', 'active_view'));
    })->name('timeline.me');
});

Route::get('/browsing-history', [RecentlyViewedController::class, 'index'])
    ->name('view-history.index');

Route::get('/shop/{slug}/{product}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('category.index');
Route::get('categories/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/cart', ViewCart::class);
