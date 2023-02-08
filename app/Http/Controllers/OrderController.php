<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Constants\Order as OrderConstants;

class OrderController extends Controller
{
    private $orderRepository;
    private $orderService;
    public function __construct(
        OrderRepository $_orderRepository,
        OrderService $_orderService
    ) {
        $this->orderRepository = $_orderRepository;
        $this->orderService = $_orderService;
    }
    public function index()
    {
        $data = $this->orderRepository->paginate(OrderConstants::ORDER_LIMIT_SHOW);
        return view('orders.orderManager', ['orders' => $data]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $data = $this->orderService->getOrderById($id);
        return view('orders.orderDetail', $data);
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
