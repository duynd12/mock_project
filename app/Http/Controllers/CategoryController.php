<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Constants\Category as CategoryConstants;
use App\Services\ProductService;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $categoryService;
    private $productService;

    public function __construct(
        CategoryRepository $_categoryRepository,
        CategoryService $_categoryService,
        ProductService $_productService
    ) {
        $this->categoryRepository = $_categoryRepository;
        $this->categoryService = $_categoryService;
        $this->productService = $_productService;
    }

    public function index()
    {
        $data = $this->categoryRepository->paginate(CategoryConstants::LIMIT_SHOW);
        return view('categories.categoryManager', ['data' => $data]);
    }

    public function create()
    {
        return view('categories.addCategory');
    }

    public function store(Request $request)
    {
        $this->categoryService->createCategory($request);
        return redirect()->back();
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $products = Product::all();
        $data = $this->categoryRepository->find($id);
        $data[CategoryConstants::KEY_NAME_ARRAY] = $this->productService->getProductName($id);

        return view('categories.editCategory', [
            'data' => $data,
            'products' => $products
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->categoryService->updateCategory($request, $id);
        return redirect()->route('category.edit', $id);
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);
        return redirect()->back();
    }
}
