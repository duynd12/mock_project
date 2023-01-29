<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'price', 'description', 'quantity'];

    // public function attributes()
    // {
    //     return $this->belongsToMany(Attribute::class, 'attribute_products')->withPivot('value_name');;
    // }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_products');
    }
    public function getAttr($params = 'color', $id = '16')
    {
        $data = DB::table('products as p')
            ->join('attribute_products as ap', 'p.id', '=', 'ap.product_id')
            ->join('attribute_values as av', 'ap.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'a.id', '=', 'av.attribute_id')
            ->where('a.name', '=', $params)
            ->where('p.id', '=', $id)
            ->select('av.value_name')
            ->get();

        return $data;
    }
}
