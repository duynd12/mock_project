<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data = $this->categoryRepository->paginate(5);
        return view('categories.categoryManager', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.addCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->only('title', 'parentId');

            $this->categoryRepository->create($data);
            return redirect()->route('categories.addCategory');
            Notify::success('Them thanh cong');
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $products = Product::all();
        // dd($products);
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
        // dd($data);
        return view('categories.editCategory', [
            'data' => $data,
            'products' => $products
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
        $this->categoryService->updateCategory($request, $id);
        return redirect()->route('category.edit', $id);
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
}
