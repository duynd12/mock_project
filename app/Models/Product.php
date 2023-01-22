<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'price', 'description', 'quantity'];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_products')->withPivot('value_name');;
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
