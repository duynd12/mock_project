<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Attribute;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Product::paginate(\App\Constants\Product::PRODUCT_LIST_LIMIT);

        // $data = $this->productRepository->all();
        $data = Product::with(['images'])->paginate(20);
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::with(['images'])->get()->find($id);
        $data['sizes'] = $this->productService->getAttribute('size', $id);
        $data['colors'] = $this->productService->getAttribute('color', $id);

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
