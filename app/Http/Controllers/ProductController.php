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
        return view('products.editProduct', ['data' => $data]);
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
        $result = $this->productService->updateProduct($data, $id);
        if ($result) {
            Notify::success('Sửa sản phẩm thành công', $title = null, $options = []);
            return redirect()->route('product.index');
        } else {
            Notify::error('Sửa sản phẩm thất bại', $title = null, $options = []);
            return redirect()->route('product.edit', $id);
        }
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
