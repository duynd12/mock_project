<?php

use App\Http\Controllers\AdminContrller;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
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


// Route::get('/', function () {
//     return view('index');
// })->name('dashboard');

Route::middleware('checklogin')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('users', [UserController::class, 'index'])->name('user.index');

    Route::controller(ProductController::class)->group(function () {
        Route::get('/product-manager', 'index')->name('product.index');
        Route::get('/them-san-pham', 'create')->name('product.create');
        Route::post('/createProduct', 'store')->name('prodcut.store');

        Route::middleware('checkRule')->group(function () {
            Route::get('/sua-san-pham/{id}', 'edit')->name('product.edit');
            Route::patch('/edit-product/{id}', 'update')->name('product.update');
            Route::delete('/deleteProduct/{id}', 'destroy')->name('product.destroy');
        });
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/quan-ly-danh-muc', 'index')->name('category.index');
        Route::get('/them-danh-muc', 'create')->name('category.create');
        Route::post('/createCategory', 'store')->name('category.store');
        Route::middleware('checkRule')->group(function () {
            Route::get('/quan-ly-danh-muc/{id}', 'edit')->name('category.edit');
            Route::patch('/edit-category/{id}', 'update')->name('category.update');
            Route::delete('/deleteCategory/{id}', 'destroy')->name('category.destroy');
        });
    });
    Route::controller(AttributeController::class)->group(function () {
        Route::get('/quan-ly-thuoc-tinh', 'index')->name('attribute.index');
        Route::post('/attribute', 'store')->name('attribute.store');
        Route::get('/them-thuoc-tinh', 'create')->name('attribute.create');
        Route::get('/chi-tiet-thuoc-tinh/{id}', 'show')->name('attribute.show');
        Route::middleware('checkRule')->group(function () {
            Route::get('/quan-ly-thuoc-tinh/{id}', 'edit')->name('attribute.edit');
            Route::patch('/edit-attribute/{id}', 'update')->name('attribute.update');
            Route::delete('/deleteAttribute/{id}', 'destroy')->name('attribute.destroy');
        });
    });
    Route::get('orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('thong-ke', [StatisticController::class, 'index'])->name('statistic.index');
    Route::get('doi-mat-khau', [AdminContrller::class, 'edit'])->name('admin.edit');
    Route::get('chi-tiet-don-hang/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('doi-mat-khau', [AdminContrller::class, 'update'])->name('admin.update');

    Route::middleware('checkRule')->group(function () {
        Route::patch('user-unlock/{id}', [UserController::class, 'update'])->name('user.unlock');
        Route::patch('user-lock/{id}', [UserController::class, 'update'])->name('user.lock');
    });
    Route::post('them-value-thuoc-tinh/{id}', [AttributeValueController::class, 'store'])->name('attributeValue.store');
    Route::get('them-value-thuoc-tinh/{id}', [AttributeValueController::class, 'create'])->name('attributeValue.create');
    Route::middleware('checkRule')->group(function () {
        Route::get('sua-value-thuoc-tinh/{id}', [AttributeValueController::class, 'edit'])->name('attributeValue.edit');
        Route::patch('sua-value-thuoc-tinh/{id}', [AttributeValueController::class, 'update'])->name('attributeValue.update');
        Route::delete('xoa-value-thuoc-tinh/{id}', [AttributeValueController::class, 'destroy'])->name('attributeValue.destroy');
    });
});
Route::controller(AdminContrller::class)->group(function () {
    Route::get('admin/login', 'create')->name('admin.create');
    Route::get('admin/register', 'createRegister')->name('admin.createRegister');
    Route::post('admin/login', 'login')->name('admin.login');
    Route::post('admin/register', 'store')->name('admin.store');
    Route::get('admin/logout', 'logout')->name('admin.logout');
});
