<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $userRepository;
    private $productsRepository;
    private $orderService;
    private $productService;
    private $orderRepository;

    public function __construct(
        UserRepository $_userRepository,
        ProductRepository $_productsRepository,
        OrderService $_orderService,
        ProductService $_productService,
        OrderRepository $_orderRepository
    ) {
        $this->userRepository = $_userRepository;
        $this->productsRepository = $_productsRepository;
        $this->orderService = $_orderService;
        $this->productService = $_productService;
        $this->orderRepository = $_orderRepository;
    }
    public function index(Request $request)
    {
        $date = $this->orderService->getDate($request);

        $user_count = $this->userRepository->getCountUser();
        $product_count = $this->productsRepository->getCountProduct();

        $orders = $this->orderService->getOrder($date);
        $sum = $this->productService->getSumOrder();
        $count_order = $this->orderRepository->all()->count();

        return view('dashboard.home', [
            'user_count' => $user_count,
            'product_count' => $product_count,
            'total_price' => $sum,
            'orders' => $orders,
            'count_order' => $count_order
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
