<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\SocialAuthController;


Route::get('/', [HomeController::class, 'indexHomePage'])->name('home');
Route::get('/catalog', [CatalogController::class, 'indexCatalogPage'])->name('catalog');
Route::get('/catalog/load-more', [CatalogController::class, 'loadMoreShoes']);

Route::get('/login', [LoginController::class, 'indexLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authUser'])->name('login.auth');
Route::get('/register', [RegisterController::class, 'indexRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'storeUser'])->name('register.store');

Route::get('login/google', [SocialAuthController::class, 'redirect'])->name('login.google');
Route::get('login/google/callback', [SocialAuthController::class, 'callback']);

Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-of-service', 'terms-of-service');

Route::get('/a/dashboard', [DashboardController::class, 'indexDashboardPage'])->name('admin.dashboard');
Route::get('/a/products', [ProductsController::class, 'indexProductsPage'])->name('admin.products');
Route::get('/a/orders', [OrdersController::class, 'indexOrdersPage'])->name('admin.orders');