<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    public function index()
    {
        $data = Order::with(['orderDetails'])->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {

        $id = JWTAuth::user()->id;
        $data = $request->all();
        try {
            DB::beginTransaction();
            $order = Order::create([
                'user_id' => $id,
                'total_price' => $data['total_price'],
                'order_date' => Carbon::now(),
                'status' => "Đã hoàn thành"
            ]);
            foreach ($data['order_detail'] as $orderDetail) {
                $product = Product::findOrFail($orderDetail['product_id']);

                $quantity = $product['quantity'] - $orderDetail['quantity'];

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $orderDetail['product_id'],
                    'price' => $orderDetail['price'],
                    'quantity' => $orderDetail['quantity'],
                    'size' => $orderDetail['size'],
                    'color' => $orderDetail['color']
                ]);
                $product->update([
                    'quantity' => $quantity,
                ]);
            };

            $ships = $data['user_info'];
            Ship::create([
                "order_id" => $order->id,
                "receiver" => $ships['name'],
                "delivery_phoneNumber" => $ships['phoneNumber'],
                "delivery_email" => $ships['email'],
                "shipping_address" => $ships['address'],
            ]);
            DB::commit();
            return response()->json([
                "success" => "successfully",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function show()
    {
        $user_id = JWTAuth::user()->id;
        $orders_id = Order::where('user_id', '=', $user_id)->pluck('id');

        $product_id = OrderDetail::with(['products'])
            ->whereIn('order_id', $orders_id)
            ->pluck('product_id');


        $product = Product::with(['images', 'orderDetails'])
            ->whereIn('id', $product_id)
            ->get();

        return response()->json(
            [
                'data' => $product
            ]
        );
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
