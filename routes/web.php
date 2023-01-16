<?php

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
    $product = Product::find(1)->attributes;
    foreach ($product as $pro) {
        var_dump($pro);
    }
});

Route::get('/listCategories', function () {
    $product = Category::find(1)->products;
    foreach ($product as $pro) {
        var_dump($pro);
    }
});
