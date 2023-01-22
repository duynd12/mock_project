<?php

namespace App\Repositories;

use App\Models\Order;
use App\Constants\Order as orderContants;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
    public function getFieldTotalPrice()
    {
        $data =  $this->model::where(orderContants::COLUMN_NAME_STATUS, '=', orderContants::STATUS_NAME);
        return $data->pluck(orderContants::COLUMN_NAME_TOTAL_PRICE);
    }
}
