<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Ship;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = JWTAuth::user()->id;
        $data = Order::with(['orderDetails'])->get()->find($id);
        return response()->json(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $orderDetail['product_id'],
                    'price' => $orderDetail['price'],
                    'quantity' => $orderDetail['quantity'],
                    'size' => $orderDetail['size'],
                    'color' => $orderDetail['color']
                ]);
            }
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::with(['orderDetails'])->find($id)->pluck('user_id');
        dd($data);
        $products = User::whereIn('id', $data)->get();

        dd($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
