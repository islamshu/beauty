<?php

use App\Http\Controllers\AboutusController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientSubscriptionController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Livewire\CategoryComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});

// Auth::routes();
Route::get('/login', [DashbaordController::class, 'login'])->name('login');
Route::post('/login', [DashbaordController::class, 'post_login'])->name('post_login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/login', [DashbaordController::class, 'login'])->name('login');
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    Route::get('/', [DashbaordController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [DashbaordController::class, 'logout'])->name('logout');

    Route::resource('users', UserController::class);
    Route::resource('packages', PackageController::class);
    Route::get('update_status_package', [PackageController::class, 'update_status_package'])->name('update_status_package');

    Route::resource('sliders', SliderController::class);
    Route::resource('services', ServiceController::class);
    Route::get('update_status_service', [ServiceController::class, 'update_status_service'])->name('update_status_service');

    
    Route::get('update_status_slider', [SliderController::class, 'update_status_slider'])->name('update_status_slider');
    Route::get('aboutus', [AboutusController::class, 'index'])->name('aboutus.index');
    Route::post('aboutus', [AboutusController::class, 'update'])->name('aboutus.update');
    Route::get('aboutus', [AboutusController::class, 'index'])->name('aboutus.index');
    Route::post('/check-phone', [ClientController::class, 'checkPhoneNumber'])->name('check.phone');

    Route::resource('clients', ClientController::class);

    Route::post('/clients/subscribe', [ClientSubscriptionController::class, 'store'])->name('clients.subscribe');

    Route::get('setting', [DashbaordController::class, 'setting'])->name('setting');
    Route::post('add_general', [DashbaordController::class, 'add_general'])->name('add_general');
    Route::get('edit_profile', [DashbaordController::class, 'edit_profile'])->name('edit_profile');
    Route::post('edit_profile', [DashbaordController::class, 'edit_profile_post'])->name('edit_profile_post');



    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
});
