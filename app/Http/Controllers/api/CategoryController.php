<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Constants\Category as CategoryConstants;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::with('products')->where(CategoryConstants::STATUS_NAME, '=', CategoryConstants::COLUMN_NAME)->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $id_category = Category::find($id)->products->pluck('id');
        $products = Product::with('images')
            ->whereIn('id', $id_category)
            ->paginate(CategoryConstants::LIMIT_SHOW);
        return response()->json([
            'data' => $products,
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
    }
}
