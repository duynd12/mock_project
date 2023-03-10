<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'price', 'quantity', 'size', 'color'];

    public function orders()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
