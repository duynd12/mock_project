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
    private $productRepository;
    private $productService;
    public function __construct(
        ProductRepository $_productRepository,
        ProductService $_productService
    ) {
        $this->productRepository = $_productRepository;
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
        $data['sizes'] = $this->productService->getAttribute(ProductConstants::PRODUCT_VALUE_SIZE, $id);
        $data['colors'] = $this->productService->getAttribute(ProductConstants::PRODUCT_VALUE_COLOR, $id);

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
            ->get();
        if (count($data)) {
            return response()->json($data);
        } else {
            return response()->json(['Data' => 'No Data not found'], 404);
        }
    }
}