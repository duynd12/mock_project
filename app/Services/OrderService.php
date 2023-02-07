<?php

namespace App\Services;

use App\Models\Ship;
use Illuminate\Support\Facades\DB;
use App\Constants\Order as orderContants;
use App\Repositories\OrderRepository;

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $_orderRepository)
    {
        $this->orderRepository = $_orderRepository;
    }
    public function getQuantityFullDay()
    {
        $orders =  DB::table('orders')
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
                        END AS day_of_week ")
            ->groupBy('day_of_week');

        return $orders;
    }
    public function getQuantityByDay($day)
    {
        $orders_where_day = $this->getQuantityFullDay()->having("day_of_week", '=', $day)
            ->get()
            ->toArray();
        return $orders_where_day[0]->So_luong_da_ban;
    }
    public function getOrderDetail($id)
    {
        $data = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('ships as s', 's.order_id', '=', 'o.id')
            ->join('products as p', 'p.id', '=', 'od.product_id')
            ->where('o.id', '=', $id)
            ->where('o.status', '=', OrderContants::STATUS_NAME)
            ->select('od.*', 'p.name')
            ->get();
        return $data;
    }

    public function getListProductsold()
    {
        $data = DB::table('order_details as od')
            ->join('products as p', 'od.product_id', '=', 'p.id')
            ->groupBy('od.product_id', 'p.name')
            ->select('od.product_id', 'p.name', DB::raw('SUM(od.quantity) as total_quantity'))
            ->get()
            ->toArray();

        return $data;
    }

    public function getUserBuyMax()
    {
        $max_quantity = array_reduce($this->getListProductsold(), function ($carry, $item) {
            return max($carry, $item->total_quantity);
        });

        return $max_quantity;
    }
    public function getProductMaxQuantity()
    {
        $array = [];
        foreach ($this->getListProductsold() as $product) {
            if ($product->total_quantity == $this->getUserBuyMax()) {
                $array[] = $product;
            }
        }
        return $array;
    }

    public function getDaysold()
    {
        $orders = $this->getQuantityFullDay()
            ->get()
            ->toArray();

        $array_day = [];
        foreach ($orders as $order) {
            $array_day[] = $order->day_of_week;
        }

        return $array_day;
    }

    public function getDataChart()
    {
        $data_chart = [];
        foreach (OrderContants::ARRAY_DAY as $day) {
            if (in_array($day, $this->getDaysold())) {
                $data_chart[] = $this->getQuantityByDay($day);
            } else {
                $data_chart[] = 0;
            }
        };

        return $data_chart;
    }


    public function getStatistic()
    {
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(OrderContants::ARRAY_DAY)
            ->datasets([
                [
                    'label' => "Số hóa đơn theo thứ",
                    'data' => $this->getDataChart(),
                    'borderColor' => "rgba(0, 194, 146, 0.9)",
                    'borderWidth' => "0",
                    'backgroundColor' => "rgba(0, 194, 146, 0.5)"
                ]
            ])
            ->options([]);

        return $chartjs;
    }
    public function getOrderById($id)
    {
        $info_user = Ship::findOrFail($id);
        $data = $this->getOrderDetail($id);

        return [
            'data' => $data,
            'info_user' => $info_user
        ];
    }
    public function getOrder($array)
    {
        $data = $this->orderRepository->searchWithTime($array);
        return $data;
    }
}