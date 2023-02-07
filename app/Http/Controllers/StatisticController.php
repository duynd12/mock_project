<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    private $orderService;
    public function __construct(OrderService $_orderService)
    {
        $this->orderService = $_orderService;
    }

    public function index()
    {
        $array = $this->orderService->getProductMaxQuantity();
        $chartjs = $this->orderService->getStatistic();
        return view('statistic.statistic', [
            'data' => $array,
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