<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $userRepository;
    private $productsRepository;
    private $orderService;
    private $productService;

    public function __construct(
        UserRepository $_userRepository,
        ProductRepository $_productsRepository,
        OrderService $_orderService,
        ProductService $_productService
    ) {
        $this->userRepository = $_userRepository;
        $this->productsRepository = $_productsRepository;
        $this->orderService = $_orderService;
        $this->productService = $_productService;
    }
    public function index(Request $request)
    {
        $date = [
            'start_date' => Carbon::today()->startOfDay(),
            'end_date' => Carbon::today()->endOfDay()
        ];

        if ($request['start_date'] && $request['end_date']) {
            $date = $request->all();
        };

        $user_count = $this->userRepository->getCountUser();
        $product_count = $this->productsRepository->getCountProduct();

        $orders = $this->orderService->getOrder($date);
        $sum = $this->productService->getSumOrder();

        return view('dashboard.home', [
            'user_count' => $user_count,
            'product_count' => $product_count,
            'total_price' => $sum,
            'orders' => $orders
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