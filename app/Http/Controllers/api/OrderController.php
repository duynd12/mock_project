<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
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
        // try {
        // DB::beginTransaction();
        // dd(array($request->data));
        foreach ($request->data as $orderDetail) {
            echo $orderDetail;
        }
        dd(1);
        $order = Order::create([
            'user_id' => $id,
            'total_price' => $data['total_price'],
            'order_date' => getdate()
        ]);
        foreach ($request->data as $orderDetail) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $orderDetail->product_id,
                'price' => $orderDetail->price,
                'quantity' => $orderDetail->quantity,
                'size' => $orderDetail->size,
                'color' => $orderDetail->color
            ]);
        }
        // DB::commit();
        //     } catch (\Exception $e) {
        //         DB::rollBack();
        //     }
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
