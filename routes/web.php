<?php

use App\Http\Controllers\CategoryController;
use App\Models\Connect\Profile\Profile;
use App\Http\Controllers\Connect\Content\PostController;
use App\Http\Controllers\Buy\Product\OrderController;
use App\Http\Controllers\Build\Sellable\Product\ProductController;
use App\Http\Livewire\BuildAndManage\Business\BusinessDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Connect\Profile\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Information\Search\SearchEngineController;
use App\Http\Controllers\Buy\Core\ShopController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\Connect\Content\BookmarkController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Connect\Profile\UpdateProfile;
use App\Http\Livewire\BuildAndManage\Manager\ManagerDashboard;
use App\Models\Connect\Conversation\DirectConversation;
use App\Http\Livewire\Connect\Conversation\Talk;

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

Route::get('/maintainance', fn () => view('guest-landing-page'));
Route::get('/', function () {
    return (Auth::check()) ? view('auth-landing-page', ['profile' => Auth::user()->currentProfile]) : view('guest-landing-page');
})->name('home');
Route::get('/@{profile:tag}/{action_route?}', [ProfileController::class, 'show'])->name('profile.visit');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::any('/guest/@{tag}/follow', fn ($tag) => redirect("/@{$tag}/"))->name('guest.follow-profile');
    Route::post('/push', [PushController::class, 'store']);
    Route::get('/@{profile:tag}/actions/edit', UpdateProfile::class)->middleware('can:access,profile')->name('profile.edit');
    Route::put('/current-profile/update', [ProfileController::class, 'updateCurrentProfile'])->name('current-profile.update');
    Route::get('/biz/dashboard/', ManagerDashboard::class)->name('manager.dashboard');

    /** Business routes */
    Route::middleware(['can:reference-businesses'])->group(function () {
        Route::get('/biz/@{profile:tag}/{action_route?}/{action_route_resource?}', BusinessDashboard::class)->middleware(['can:sellWith,profile'])->name('business.dashboard');
        Route::get('/biz/@{profile:tag}/warehouse/{active_item?}/', function (Profile $profile, $active_product) {
            return redirect(route('business.dashboard', ['profile' => $profile->tag, 'action_route' => 'products', 'action_route_resource' => $active_product]));
        })->middleware(['can:sellWith,profile'])->name('business.products');
    });
    Route::get('/chat', fn () => view('chat.index', [
        'profile' => Auth::user()->profile,
        'activeConversation' => (request()->input('active_conversation')) ? DirectConversation::firstWhere('secret_key', request()->input('active_conversation')) : null
    ]))->name('chat.index');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::get('/post/{post}/delete', [PostController::class, 'destroy'])->name('post.delete');
    Route::get('/post/{post}/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::get('/post/{post}/comment/{comment}/delete', [CommentController::class, 'destroy'])->name('comment.delete');
    Route::get('/post/{post}/comment/{comment}', [CommentController::class, 'show'])->name('comment.show');
    Route::get('/post/{post}/comment/{comment}/replies/{reply}/edit', [ReplyController::class, 'edit'])->name('reply.edit');
    Route::get('/post/{post}/comment/{comment}/replies/{reply}/delete', [ReplyController::class, 'destroy'])->name('reply.delete');
    Route::get('/post/{post}/comment/{comment}/replies/{reply}/', [ReplyController::class, 'show'])->name('reply.show');
    Route::get('/chat/private-conversation.{me}/{conversation:secret_key}', Talk::class)->name('chatEngine.talk');
    Route::get('/@{profile:tag}/view/bookmarks', [BookmarkController::class, 'index'])->name('bookmark.index');
    Route::get('/me/preview_order/', [OrderController::class, 'preview_order'])->name('order.preview_order');
    Route::get('/me/place_order', [OrderController::class, 'place_order'])->name('order.place_order');
    Route::get('/order_success', fn () => view('order.success_page', [
        'order' => auth()->user()->orders->first()
    ]));
    Route::get('@{profile:tag}/view/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('@{profile:tag}/view/following', [ProfileController::class, 'following'])->name('profile.following');
});
Route::get('/shop/{slug}/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search/{data?}', [SearchEngineController::class, 'index'])->name('search.index');
