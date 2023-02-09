<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    private $categoryRepository;
    private $productService;

    public function __construct(
        CategoryRepository $_categoryRepository,
        ProductService $_productService
    ) {
        $this->categoryRepository = $_categoryRepository;
        $this->productService = $_productService;
    }
    public function createCategory($request)
    {
        try {
            $data = $request->only('title', 'status');
            $this->categoryRepository->create($data);
            Notify::success('Them thanh cong');
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }
    public function updateCategory($request, $id)
    {
        try {
            DB::beginTransaction();

            // 7022023 test
            $data = $this->productService->getIdCateOrProduct('product', $id);
            $data_product = $request->only('products');
            $array_data = $request->all();
            $categories = Category::find($id);


            if (count($data_product) > 0) {
                foreach ($data as $value) {
                    if (!in_array($value, $data_product['products'])) {
                        $categories->products()->detach($value);
                    }
                }
                foreach ($data_product['products'] as $value) {
                    if (!in_array($value, $data)) {
                        $categories->products()->attach($value);
                    }
                }
            }
            $this->categoryRepository->update([
                'title' => $array_data['title'],
                'status' => $array_data['status']
            ], $id);

            DB::commit();
            Notify::success('Sửa danh mục thành công');
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
            DB::rollBack();
        }
    }

    public function deleteCategory($id)
    {
        try {
            DB::beginTransaction();
            $category = $this->categoryRepository->find($id);
            $category->delete();
            $category->products()->detach($id);
            DB::commit();
            Notify::success('Them thanh cong');
        } catch (\Exception $e) {
            DB::rollBack();
            Notify::error($e->getMessage());
        }
    }
}
