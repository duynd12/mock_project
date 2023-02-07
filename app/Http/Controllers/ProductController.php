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
use App\Services\AttributeService;
use Illuminate\Support\Facades\DB;
use App\Constants\Attribute as AttributeConstant;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;

class ProductController extends Controller
{
    private $productRepository;
    private $productService;
    private $attributeRepository;
    private $attributeService;

    public function __construct(
        ProductRepository $_productRepository,
        ProductService $_productService,
        AttributeRepository $_attributeRepository,
        AttributeService $_attributeService
    ) {
        $this->productRepository = $_productRepository;
        $this->productService = $_productService;
        $this->attributeRepository = $_attributeRepository;
        $this->attributeService = $_attributeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->productRepository->paginate(5);
        // $data = Product::with(['images'])->get();
        // dd($data);
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
        $color_values = $this->attributeRepository->getAttributeValue(AttributeConstant::ATTRIBUTE_NAME_COLOR);
        $size_values = $this->attributeRepository->getAttributeValue(AttributeConstant::ATTRIBUTE_NAME_SIZE);
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
    public function store(AddProductRequest $request)
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
        $colors = $this->attributeService->getValueNameAttr(AttributeConstant::ATTRIBUTE_NAME_COLOR);
        $sizes = $this->attributeService->getValueNameAttr(AttributeConstant::ATTRIBUTE_NAME_SIZE);

        $data['colors'] = $this->attributeService->getAttributeByIdPRoduct($id, AttributeConstant::ATTRIBUTE_NAME_COLOR);
        $data['sizes'] = $this->attributeService->getAttributeByIdPRoduct($id, AttributeConstant::ATTRIBUTE_NAME_SIZE);

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
    public function update(EditProductRequest $request, $id)
    {
        $data = $request->all();
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
