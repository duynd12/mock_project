<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    private $orderService;
    private $productService;
    public function __construct(
        OrderService $_orderService,
        ProductService $_productService
    ) {
        $this->orderService = $_orderService;
        $this->productService = $_productService;
    }

    public function index()
    {
        $array = $this->orderService->getProductMaxQuantity();
        $chartjs = $this->orderService->getStatistic();
        $customer_buy = $this->productService->getCustomerBuyMax();
        $customer_buy_info = $this->productService->getCustomerBuyInfo($customer_buy);

        return view('statistic.statistic', [
            'data' => $array,
            'customer_buy' => $customer_buy,
            'customer_buy_info' => $customer_buy_info,
            'chartjs' => $chartjs
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
