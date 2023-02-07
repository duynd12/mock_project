<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'total_price', 'status', 'order_date'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details');
    }
}
