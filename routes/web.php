<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminController::class, 'admin'])->name('adminAdmin');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
    Route::get('/products', [AdminController::class, 'products'])->name('adminProducts');
    Route::prefix('products')->group(function() {
        Route::post('/createProduct', [AdminController::class, 'createProduct'])->name('createProduct');
    });
    Route::get('/product/{product}', [AdminController::class, 'product'])->name('adminProduct');
    Route::get('/categories', [AdminController::class, 'categories'])->name('adminCategories');
    Route::prefix('categories')->group(function() {
        Route::post('/createCategory', [AdminController::class, 'createCategory'])->name('createCategory');
    });
    Route::get('/category/{category}', [AdminController::class, 'category'])->name('adminCategory');
    Route::get('/enterAsUser/{id}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    Route::post('/exportCategories', [AdminController::class, 'exportCategories'])->name('exportCategories');
    Route::post('/importCategories', [AdminController::class, 'importCategories'])->name('importCategories');
    Route::post('/exportProducts', [AdminController::class, 'exportProducts'])->name('exportProducts');
    Route::post('/importProducts', [AdminController::class, 'importProducts'])->name('importProducts');
    Route::prefix('roles')->group(function() {
        Route::post('/add', [AdminController::class, 'addRole'])->name('addRole');
        Route::post('/addRoleToUser', [AdminController::class, 'addRoleToUser'])->name('addRoleToUser');
    });
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('cart');
    Route::post('/removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('/createOrder', [CartController::class, 'createOrder'])->name('createOrder');
    Route::post('/repeatOrder', [CartController::class, 'repeatOrder'])->name('repeatOrder');
});

Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/profile/{user}', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/save', [ProfileController::class, 'save'])->name('saveProfile');

Auth::routes();