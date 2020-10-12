<?php

use App\Http\Livewire\Enterprise\ManageEnterprise;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['can:own-enterprise'])->group(function () {
        Route::get('/manager-dashboard', function () {
            return view('/manager-dashboard');
        })->name('manager-dashboard');
        Route::get('/e-prises/{enterprise}', ManageEnterprise::class)->name('enterprise-dashboard');
    });
});
