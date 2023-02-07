<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Constants\Category as CategoryConstants;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $categoryService;

    public function __construct(
        CategoryRepository $_categoryRepository,
        CategoryService $_categoryService
    ) {
        $this->categoryRepository = $_categoryRepository;
        $this->categoryService = $_categoryService;
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
        $data['product_name'] = DB::table('category_products as cp')
            ->join('categories as c', 'c.id', '=', 'cp.category_id')
            ->join('products as p', 'p.id', '=', 'cp.product_id')
            ->where('c.id', '=', $id)
            ->select('p.id', 'p.name')
            ->get()
            // ->keyBy('name')
            ->toArray();
        // dd($data);
        // dd($data['status']);

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