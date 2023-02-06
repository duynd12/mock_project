<?php

use App\Http\Controllers\AdminContrller;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatisticController;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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


// Route::get('/', function () {
//     return view('index');
// })->name('dashboard');

Route::middleware('checklogin')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home.index');

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
        Route::get('/chi-tiet-thuoc-tinh/{id}', 'show')->name('attribute.show');
    });
    Route::get('orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('thong-ke', [StatisticController::class, 'index'])->name('statistic.index');

    Route::get('chi-tiet-don-hang/{id}', [OrderController::class, 'show'])->name('order.show');
});
Route::controller(AdminContrller::class)->group(function () {
    Route::get('admin/login', 'create')->name('admin.create');
    Route::get('admin/register', 'createRegister')->name('admin.createRegister');
    Route::post('admin/login', 'login')->name('admin.login');
    Route::post('admin/register', 'store')->name('admin.store');
    Route::get('admin/logout', 'logout')->name('admin.logout');
});
Route::get('them-value-thuoc-tinh/{id}', [AttributeValueController::class, 'showformCreate'])->name('attributeValue.showformCreate');
Route::post('them-value-thuoc-tinh/{id}', [AttributeValueController::class, 'store'])->name('attributeValue.store');
Route::get('sua-value-thuoc-tinh/{id}', [AttributeValueController::class, 'edit'])->name('attributeValue.edit');
Route::post('sua-value-thuoc-tinh/{id}', [AttributeValueController::class, 'update'])->name('attributeValue.update');
Route::get('xoa-value-thuoc-tinh/{id}', [AttributeValueController::class, 'destroy'])->name('attributeValue.destroy');

Route::get('sua-value-thuoc-tinh/{id}', [AttributeController::class, 'edit'])->name('attribute.edit');
Route::post('sua-value-thuoc-tinh/{id}', [AttributeController::class, 'update'])->name('attribute.update');





Route::get('test', function () {
    $data = DB::table('order_details as od')
        ->join('products as p', 'od.product_id', '=', 'p.id')
        ->groupBy('od.product_id', 'p.name')
        ->select('od.product_id', 'p.name', DB::raw('SUM(od.quantity) as total_quantity'))
        ->get()
        // ->first();
        ->toArray();
    // dd($data);


    $max_quantity = array_reduce($data, function ($carry, $item) {
        return max($carry, $item->total_quantity);
    });
    $array = [];
    foreach ($data as $product) {
        if ($product->total_quantity == $max_quantity) {
            $array[] = $product;
        }
    }
    dd($array);
    // $products = Product::find($data->product_id);
    // dd($products);

    // dd($max_quantity);
    // return max($max_quantity);
    // return $data;
});
// Route::get('userbuy', function () {
//     $bestCustomer = DB::table('orders')
//         ->select('user_id', DB::raw('SUM(total_price) as total_spending'))
//         ->groupBy('user_id')
//         ->orderBy('total_spending', 'desc')
//         ->first();
//     $bestCustomerUser = DB::table('users as u')
//         ->join('profiles as p', 'p.user_id', '=', 'u.id')
//         ->where('id', $bestCustomer->user_id)->first();
//     dd($bestCustomer);
// });

// Route::get('ordertoday', function (Request $request) {
//     // dd($request);
//     $start_date = Carbon::parse($request->start_date);
//     $end_date = Carbon::parse($request->end_date);

//     $orders = Order::whereBetween('created_at', [$start_date, $end_date])->get();
//     dd($orders);
//     // dd(Carbon::today());
//     // $orders = Order::whereDate('order_date', Carbon::today())->get();
//     // dd($orders);
// });

Route::get('test1', function () {
    $data =  DB::table('orders')
        ->selectRaw(" count(id) as So_luong_da_ban,
	CASE
    	WHEN DAYOFWEEK(order_date) = '1' THEN 'Sunday'
        WHEN DAYOFWEEK(order_date) = '2' THEN 'Monday'
        WHEN DAYOFWEEK(order_date) = '3' THEN 'Tuesday'
        WHEN DAYOFWEEK(order_date) = '4' THEN 'Wednesday'
        WHEN DAYOFWEEK(order_date) = '5' THEN 'Thursday'
        WHEN DAYOFWEEK(order_date) = '6' THEN 'Friday'
        WHEN DAYOFWEEK(order_date) = '7' THEN 'Saturday'
        ELSE 'not a day of week'
    END AS day_of_week
    ")
        ->groupBy('day_of_week')
        ->get()
        ->toArray();

    dd($data);
});
