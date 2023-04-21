<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\CartManage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {


    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin_categories');
    Route::get('/admin/categories/new', [CategoryController::class, 'add'])->name('admin_categories_new');
    Route::post('/admin/categories/new/store', [CategoryController::class, 'store'])->name('admin_categories_new_store');

    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin_products');
    Route::get('/admin/products/new', [ProductController::class, 'add'])->name('admin_products_new');
    Route::post('/admin/products/new/store', [ProductController::class, 'store'])->name('admin_products_new_store');


//   Route::get('/{pages}', [CategoryController::class])->name('page')->where('pages', 'categories|add_category');

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile-page');
    Route::get('/edit', [PageController::class, 'edit'])->name('edit-page');

});

Route::get('/', [PageController::class, 'index'])->name('main-page');

//Route::get('/prod-detail/{id}', [PageController::class, 'prod_detail'])->name('prod_detail');

Route::group([
    'as' => 'product.',
    'prefix' => 'product',
    'controller' => ProductsController::class
], function () {
    Route::get('/{id}/detail', 'detail')->name('detail');
    Route::get('/add-to-cart/{id}', 'addToCart')->name('add.to.cart');

//    Route::get('/cart', 'cart')->name('cart-page');
    Route::get('/cart', CartManage::class)->name('cart-page');

//    Route::put('/update-cart', 'update')->name('update.cart');
//    Route::delete('/remove-from-cart', 'remove')->name('remove.from.cart');

});
Route::get('/order-create', [OrderController::class, 'index'])->name('order-create');
Route::post('/order-store', [OrderController::class, 'store'])->name('order-store');


Route::get('/login', [PageController::class, 'login'])->name('login-page');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/sign-up', [PageController::class, 'signup'])->name('signup-page');
Route::post('/sign-up', [UserController::class, 'signup'])->name('sign-up');

Route::get('/rules', [PageController::class, 'rules'])->name('rules-page');
Route::get('/restaurant', [PageController::class, 'restaurant'])->name('restaurant-page');
Route::get('/restaurant2', [PageController::class, 'restaurant2'])->name('restaurant2-page');
Route::get('/restaurant3', [PageController::class, 'restaurant3'])->name('restaurant3-page');
Route::get('/address', [PageController::class, 'address'])->name('address-page');


Route::get('/forgot-password', [PageController::class, 'password'])->name('password-page');
Route::post('/forgot-password', [UserController::class, 'password'])->name('password');

Route::get('/reset-password', [PageController::class, 'reset'])->name('password.reset');
Route::post('/reset-password', [UserController::class, 'reset'])->name('password.update');

Route::get('/email/verify', [UserController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [UserController::class, 'send'])->name('verification.send');
