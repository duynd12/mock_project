<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    private $categoryRepository;
    public function __construct(CategoryRepository $_categoryRepository)
    {
        $this->categoryRepository = $_categoryRepository;
    }
    public function updateCategory($request, $id)
    {
        try {
            DB::beginTransaction();
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
            $array_data = $request->all();
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
            DB::commit();
            Notify::success('Sửa danh mục thành công');
        } catch (\Exception $e) {
            Notify::error('Sửa danh mục thất bại');
            DB::rollBack();
        }
    }
}
