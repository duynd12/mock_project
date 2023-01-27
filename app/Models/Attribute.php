<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_products')->select('value_name');
    }

    // public function attributes()
    // {
    //     return $this->hasMany(Attribute_Product::class, 'attribute_products');
    // }
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
