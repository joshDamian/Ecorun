<?php

use App\Http\Controllers\CategoryController;
use App\Models\Profile;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecentlyViewedController;
use App\Http\Livewire\BuildAndManage\Business\BusinessDashboard;
use App\Http\Livewire\UserComponents\Cart\ViewCart;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Connect\Profile\UpdateProfile;
use App\Http\Livewire\BuildAndManage\Manager\ManagerDashboard;
use App\Models\DirectConversation;

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
        return (Auth::check()) ? view('auth-landing-page', ['profile' => Auth::user()->currentProfile]) : view('guest-landing-page');
    }
)->name('home');


Route::get('/@{profile:tag}/{action_route?}', [ProfileController::class, 'show'])->name('profile.visit');

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

        Route::get('/@{profile:tag}/actions/edit', UpdateProfile::class)->middleware('can:access,profile')
            ->name('profile.edit');

        Route::put('/current-profile/update', [ProfileController::class, 'updateCurrentProfile'])->name('current-profile.update');

        Route::get('/biz/dashboard/', ManagerDashboard::class)->name('manager.dashboard');

        Route::middleware(['can:reference-businesses'])->group(
            function () {
                Route::get('/biz/@{profile:tag}/{action_route?}/{action_route_resource?}', BusinessDashboard::class)->middleware(['can:sellWith,profile'])->name('business.dashboard');

                Route::get(
                    '/biz/@{profile:tag}/products/{active_product?}/',
                    function (Profile $profile, $active_product) {
                        return redirect(route('business.dashboard', ['profile' => $profile->tag, 'action_route' => 'products', 'action_route_resource' => $active_product]));
                    }
                )->middleware(['can:sellWith,profile'])->name('business.products');
            }
        );

        Route::get('/chat', function () {
            return view('chat.index', ['profile' => Auth::user()->profile, 'activeConversation' => (request()->input('active_conversation')) ? DirectConversation::firstWhere('secret_key', request()->input('active_conversation')) : null]);
        })->name('chat.index');

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

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::get('/search/{data}', function ($data) {
    return dd(App\Models\Post::withAnyTags([$data])->get());
})->name('search');
