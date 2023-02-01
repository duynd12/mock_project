<?php

use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
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
// Route::get('/123', function () {
//     dd(1);
//     return view('index');
// });
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
Route::controller(AttributeController::class)->group(function () {
    Route::get('/quan-ly-thuoc-tinh', 'index')->name('attribute.index');
    Route::get('/quan-ly-thuoc-tinh/{id}', 'edit')->name('attribute.edit');
    Route::post('/edit-attribute/{id}', 'update')->name('attribute.update');
    Route::post('/attribute', 'store')->name('attribute.store');
    Route::get('/deleteAttribute/{id}', 'destroy')->name('attribute.destroy');
    Route::get('/them-thuoc-tinh', 'create')->name('attribute.create');
});
Route::get('orders', [OrderController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home.index');
// Route::get('/quan-ly-thuoc-tinh', [AttributeController::class, 'index'])->name('attribute.index');

// Route::get('/test', function () {
//     $data['product_name'] = DB::table('category_products as cp')
//         ->join('categories as c', 'c.id', '=', 'cp.category_id')
//         ->join('products as p', 'p.id', '=', 'cp.product_id')
//         ->where('c.id', '=', 1)
//         ->select('p.id')
//         ->get()
//         ->keyBy('id')
//         ->toArray();
//     // foreach ($data as $d) {
//     //     // dd($d);
//     //     array_push($array, $d);
//     // }    
//     // dd($data);
//     // $data2 = $request->only('products');

//     // foreach ($data['product_name'] as $key => $val) {
//     //     array_push($array, $d);
//     // }
//     // dd($data);
//     // dd($data2);
//     // $diffarray = array_diff($data, $data2);
//     // dd($diffarray);
// });

Route::group(['middleware' => ['jwt.verify']], function () {
    // Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::get('orders', [OrderController::class, 'index']);
});
