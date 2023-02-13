<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['jwt.verify', 'auth:api']], function () {
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::get('member/history', [OrderController::class, 'show']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::put('member/edit', [ProfileController::class, 'update']);
});
Route::middleware('auth:sanctum')->get('/user1', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('logout', 'logout');
});

Route::controller(ProductController::class)->group(function () {

    Route::get('products', 'index');
    Route::get('products/{id}', 'show');
    Route::get('search', 'searchProduct');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('categories', 'index');
    Route::get('categories/{id}', 'show');
});

// store
Route::group(['middleware' => ['jwt.verify']], function () {
});
