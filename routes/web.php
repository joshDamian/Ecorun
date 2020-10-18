<?php

use App\Http\Controllers\ProductController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Enterprise\ManageEnterprise;
use App\Http\Livewire\UserComponents\Home;
use Illuminate\Support\Facades\Route;


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

Route::get('/', Home::class);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::middleware(['can:own-enterprise'])->group(function () {
        Route::get('/manager-dashboard', function () {
            return view('/manager-dashboard');
        })->name('manager-dashboard');

        Route::get('/my-bss/{enterprise}/&view={active_action?}', ManageEnterprise::class)
            ->middleware('can:update-enterprise,enterprise')
            ->name('enterprise.dashboard');
    });
});

Route::get('/prod/{name}_{product}', [ProductController::class, 'show'])
    ->name('product.show');
