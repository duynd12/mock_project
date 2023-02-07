<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\UserController;
use App\Models\Order;
use Carbon\Carbon;
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

Route::get('orders', [OrderController::class, 'index']);
Route::group(['middleware' => ['jwt.verify', 'auth:api']], function () {
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::get('member/history', [OrderController::class, 'show']);

    Route::post('orders', [OrderController::class, 'store']);
    Route::put('member/edit', [ProfileController::class, 'update']);
});
Route::middleware('auth:sanctum')->get('/user1', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);


// Route::post('login', [UserController::class, 'login']);

Route::get('products', [ProductController::class, 'index']);
// Route::get('orders', [OrderController::class, 'index']);

Route::get('products/{id}', [ProductController::class, 'show']);
Route::get('search', [ProductController::class, 'searchProduct']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

// store
Route::group(['middleware' => ['jwt.verify']], function () {
});


// Route::get('ordertoday', function (Request $request) {
//     $start_date = Carbon::parse($request->start_date);
//     $end_date = Carbon::parse($request->end_date);

//     $orders = Order::whereBetween('order_date', [$start_date, $end_date])->get();
//     dd($orders);
//     // dd(Carbon::today());
//     // $orders = Order::whereDate('order_date', Carbon::today())->get();
//     // dd($orders);
// });