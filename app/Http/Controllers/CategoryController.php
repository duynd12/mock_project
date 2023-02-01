<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $_categoryRepository)
    {
        $this->categoryRepository = $_categoryRepository;
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
        $array = [];
        $data = DB::table('category_products as cp')
            ->join('categories as c', 'c.id', '=', 'cp.category_id')
            ->join('products as p', 'p.id', '=', 'cp.product_id')
            ->where('c.id', '=', $id)
            ->select('p.id')
            ->get()
            ->keyBy('id')
            ->toArray();
        $data2 = $request->only('products');
        foreach ($data as $key => $value) {
            $array[] = $key;
        };
        dd($array);
        $array_data = $request->all();
        // dd($array_data);
        $categories = Category::find($id);
        foreach ($array as $value) {
            // xoa product_id in pivot table
            if (!in_array($value, $data2['products'])) {
                $categories->products()->detach($value);
            }
        }

        foreach ($data2['products'] as $value) {
            // xoa product_id in pivot table
            if (!in_array($value, $array)) {
                $categories->products()->attach($value);
            }
        }

        $this->categoryRepository->update([
            'title' => $array_data['title'],
            'parentId' => $array_data['parentId']
        ], $id);
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
