<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;
use App\Repositories\AttributeRepository;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $productRepository;
    private $productService;
    private $attributeRepository;
    public function __construct(ProductRepository $_productRepository, ProductService $_productService, AttributeRepository $_attributeRepository)
    {
        $this->productRepository = $_productRepository;
        $this->productService = $_productService;
        $this->attributeRepository = $_attributeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->productRepository->paginate(5);
        // $attribute_value = AttributeValue::all();
        // $data = Product::with(['images', 'attributes'])->get();
        return view('products.productManager', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories  = Category::all();
        $color_values = $this->attributeRepository->getAttributeValue('color');
        $size_values = $this->attributeRepository->getAttributeValue('size');
        return view('products.addProduct', [
            'categories' => $categories,
            'colors' => $color_values,
            'sizes' => $size_values
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
        $this->productService->createProduct($request);
        return redirect()->route('product.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->productService->getProductById($id);
        $categories = Category::all();
        $colors = DB::table('attribute_values as av')
            ->join('attributes as a', 'av.attribute_id', '=', 'a.id')
            ->where('a.name', '=', 'color')
            ->select('av.id', 'av.value_name')
            ->get();
        $sizes = DB::table('attribute_values as av')
            ->join('attributes as a', 'av.attribute_id', '=', 'a.id')
            ->where('a.name', '=', 'size')
            ->select('av.id', 'av.value_name')
            ->get();
        $data['colors'] = DB::table('products as p')
            ->join('attribute_products as ap', 'p.id', '=', 'ap.product_id')
            ->join('attribute_values as av', 'ap.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'a.id', '=', 'av.attribute_id')
            ->where('a.name', '=', 'color')
            ->select('av.id', 'av.value_name')
            ->get();
        $data['sizes'] = DB::table('products as p')
            ->join('attribute_products as ap', 'p.id', '=', 'ap.product_id')
            ->join('attribute_values as av', 'ap.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'a.id', '=', 'av.attribute_id')
            ->where('a.name', '=', 'size')
            ->select('av.id', 'av.value_name')
            ->get();
        return view('products.editProduct', [
            'data' => $data,
            'colors' => $colors,
            'sizes' => $sizes,
            'categories' => $categories
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
        $data = $request->all();
        dd($data);
        $this->productService->updateProduct($data, $id);
        return redirect()->route('product.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('product.index');
    }
}
