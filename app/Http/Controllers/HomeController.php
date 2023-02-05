<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $userRepository;
    private $productsRepository;
    private $orderRepository;
    private $orderService;

    public function __construct(

        UserRepository $_userRepository,
        ProductRepository $_productsRepository,
        OrderRepository $_orderRepository,
        OrderService $_orderService
    ) {
        $this->userRepository = $_userRepository;
        $this->productsRepository = $_productsRepository;
        $this->orderRepository = $_orderRepository;
        $this->orderService = $_orderService;
    }
    public function index(Request $request)
    {
        $user_count = $this->userRepository->getCountUser();
        $product_count = $this->productsRepository->getCountProduct();
        $total_price = $this->orderRepository->getFieldTotalPrice();

        $date = [
            'start_date' => Carbon::today()->startOfDay(),
            'end_date' => Carbon::today()->endOfDay()
        ];
        if ($request['start_date'] && $request['end_date']) {
            $date = $request->all();
        };
        $orders = $this->orderService->getOrder($date);

        $sum = 0;
        foreach ($total_price as $price) {
            $sum += $price;
        }
        return view('dashboard.home', [
            'user_count' => $user_count,
            'product_count' => $product_count,
            'total_price' => $sum,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
