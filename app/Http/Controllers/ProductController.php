<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Models\Category;
use App\Repositories\AttributeRepository;
use App\Services\AttributeService;
use App\Constants\Attribute as AttributeConstant;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Repositories\CategoryRepository;
use App\Constants\Product as ProductConstants;

class ProductController extends Controller
{
    private $productRepository;
    private $productService;
    private $attributeRepository;
    private $attributeService;
    private $categoryRepository;

    public function __construct(
        ProductRepository $_productRepository,
        ProductService $_productService,
        AttributeRepository $_attributeRepository,
        AttributeService $_attributeService,
        CategoryRepository $_categoryRepository
    ) {
        $this->productRepository = $_productRepository;
        $this->productService = $_productService;
        $this->attributeRepository = $_attributeRepository;
        $this->attributeService = $_attributeService;
        $this->categoryRepository = $_categoryRepository;
    }

    public function index()
    {
        $data = $this->productRepository->paginate(ProductConstants::PRODUCT_LIST_LIMIT);
        return view('products.productManager', ['data' => $data]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->all();
        $color_values = $this->attributeRepository->getAttributeValue(AttributeConstant::ATTRIBUTE_NAME_COLOR);
        $size_values = $this->attributeRepository->getAttributeValue(AttributeConstant::ATTRIBUTE_NAME_SIZE);

        return view('products.addProduct', [
            'categories' => $categories,
            'colors' => $color_values,
            'sizes' => $size_values
        ]);
    }

    public function store(AddProductRequest $request)
    {
        $this->productService->createProduct($request);
        return redirect()->route('product.create');
    }

    public function show()
    {
    }

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

    public function update(EditProductRequest $request, $id)
    {
        $data = $request->all();
        $this->productService->updateProduct($data, $id);
        return redirect()->route('product.edit', $id);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('product.index');
    }
}