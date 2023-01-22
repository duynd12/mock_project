<?php

namespace App\Services;

use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Helmesvs\Notify\Facades\Notify as Notify;

class ProductService
{

    private $productRepository;
    private $imageRepository;

    public function __construct(ProductRepository $_productRepository, ImageRepository $_imageRepository)
    {
        $this->productRepository = $_productRepository;
        $this->imageRepository = $_imageRepository;
    }

    public function createProduct($request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $reslut = $this->productRepository->create($data);
            $product_id = $reslut->id;

            // if ($request['categories']) {
            //     $categories = $request['categories'];
            //     foreach ($categories as $category) {
            //         $this->productRepository->createCategoryProduct(
            //             [
            //                 'product_id' => $product_id,
            //                 'category_id' => $category
            //             ]
            //         );
            //     }
            // }
            if ($request->hasfile('images')) {
                $uploadPath = 'storage/uploads/';
                $images = $request->file('images');
                foreach ($images as $image) {
                    $extention = $image->getClientOriginalExtension();
                    $file_name = current(explode('.', $image->getClientOriginalName()));
                    $path_name = $file_name . '.' . $extention;
                    $image->move($uploadPath, $path_name);

                    $this->imageRepository->create(
                        [
                            'product_id' => $product_id,
                            'product_img' => $path_name
                        ]
                    );
                }
            }
            DB::commit();
            Notify::success('thanh cong', $title = null, $options = []);
            return redirect()->route('product.index');
        } catch (\throwable $th) {
            throw $th;
            DB::rollback();
        }
    }
}
