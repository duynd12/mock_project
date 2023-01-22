<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Models\Category;
use App\Models\Product;
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
    return view('index');
});
Route::controller(ProductController::class)->group(function () {
    Route::get('/product-manager', 'index')->name('product.index');
    Route::get('/them-san-pham', 'create')->name('product.create');
    Route::post('/createProduct', 'store')->name('prodcut.store');
    Route::get('/sua-san-pham/{id}', 'edit')->name('product.edit');
    Route::post('/edit-product/{id}', 'update')->name('product.update');
    Route::get('/deleteProduct/{id}', 'destroy')->name('product.destroy');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/quan-ly-danh-muc', 'index')->name('category.index');
    Route::get('/quan-ly-danh-muc/{id}', 'edit')->name('category.edit');
    Route::post('/edit-category/{id}', 'update')->name('category.update');
    Route::post('/createCategory', 'store')->name('category.store');
    Route::get('/deleteCategory/{id}', 'destroy')->name('category.destroy');
    Route::get('/them-danh-muc', 'create')->name('category.create');
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');
