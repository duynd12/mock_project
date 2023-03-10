<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Attribute;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Constants\Product as ProductConstants;

class ProductController extends Controller
{
    private $productService;
    public function __construct(
        ProductService $_productService
    ) {
        $this->productService = $_productService;
    }
    public function index()
    {
        $data = Product::with(['images'])->paginate(ProductConstants::PRODUCT_LIST_LIMIT);
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
        $data = Product::with(['images'])->get()->find($id);
        $data[ProductConstants::ATTRIBUTE_ARRAY_NAME_SIZE] = $this->productService->getAttribute(ProductConstants::PRODUCT_VALUE_SIZE, $id);
        $data[ProductConstants::ATTRIBUTE_ARRAY_NAME_COLOR] = $this->productService->getAttribute(ProductConstants::PRODUCT_VALUE_COLOR, $id);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function searchProduct(Request $request)
    {
        $param = $request->input('param');
        $data = Product::with(['images'])
            ->where('name', 'LIKE', '%' . $param . '%')
            ->paginate(ProductConstants::PRODUCT_LIST_LIMIT);

        return response()->json([
            'data' => $data,
        ]);
    }
}
