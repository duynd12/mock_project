<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Support\Facades\DB;
use App\Constants\Category as CategoryConstants;
use App\Constants\Notify as NotifyConstants;

class CategoryService
{
    private $categoryRepository;
    private $productService;
    private $categoryConstants;

    public function __construct(
        CategoryRepository $_categoryRepository,
        ProductService $_productService,
        CategoryConstants $_categoryConstants
    ) {
        $this->categoryRepository = $_categoryRepository;
        $this->productService = $_productService;
        $this->categoryConstants = $_categoryConstants;
    }
    public function createCategory($request)
    {
        try {
            $data = $request->only('title', 'status');
            $this->categoryRepository->create($data);
            $this->categoryConstants->setHandle(NotifyConstants::ADD);
            Notify::success($this->categoryConstants->getNotifySuccess());
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }
    public function updateCategory($request, $id)
    {
        // $data_product = $request->only('products') != null ? $request->only('products') : [];

        try {
            DB::beginTransaction();

            $data = $this->productService->getIdCateOrProduct('product', $id);

            $data_product = $request->only('products');
            if (!$request->has('products')) {
                $data_product['products'] = [];
            }

            $array_data = $request->all();
            $categories = Category::find($id);


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
            $this->categoryRepository->update([
                'title' => $array_data['title'],
                'status' => $array_data['status']
            ], $id);

            DB::commit();
            Notify::success('S???a danh m???c th??nh c??ng');
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
            $this->categoryConstants->setHandle(NotifyConstants::DELETE);
            Notify::success($this->categoryConstants->getNotifySuccess());
        } catch (\Exception $e) {
            DB::rollBack();
            Notify::error($e->getMessage());
        }
    }
}
