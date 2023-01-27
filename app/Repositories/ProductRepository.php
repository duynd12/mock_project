<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getCountProduct()
    {
        return $this->model::all()->count();
    }
    // public function all()
    // {
    //     return $this->model::with('images')->with('attributes')->get();
    // }
}
