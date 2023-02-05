<?php

namespace App\Services;

use App\Models\AttributeProduct;
use App\Models\Product;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Helmesvs\Notify\Facades\Notify as Notify;
use PhpParser\Node\Stmt\Nop;

class ProductService
{

    private $productRepository;
    private $imageRepository;

    public function __construct(ProductRepository $_productRepository, ImageRepository $_imageRepository)
    {
        $this->productRepository = $_productRepository;
        $this->imageRepository = $_imageRepository;
    }
    public function getAttributeById($params, $id)
    {
        $data = DB::table('products as p')
            ->join('attribute_products as ap', 'p.id', '=', 'ap.product_id')
            ->join('attribute_values as av', 'ap.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'a.id', '=', 'av.attribute_id')
            ->where('a.name', '=', $params)
            ->where('p.id', '=', $id)
            ->select('av.id')
            ->get()
            ->keyBy('id')
            ->toArray();

        return $data;
    }
    public function createProduct($request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data2 = $request->only(['name', 'price', 'description', 'quantity']);
            $reslut = $this->productRepository->create($data2);
            $product_id = $reslut->id;

            if ($request['categories']) {
                $product = Product::find($product_id);
                $categories = $request['categories'];
                foreach ($categories as $category) {
                    $product->categories()->attach($category);
                    // $this->productRepository->createCategoryProduct(
                    //     [
                    //         'product_id' => $product_id,
                    //         'category_id' => $category
                    //     ]
                    // );
                }
            }
            if ($request->hasfile('images')) {
                $uploadPath = 'storage/uploads/';
                $images = $request->file('images');
                foreach ($images as $image) {
                    $extention = $image->getClientOriginalExtension();
                    $file_name = current(explode('.', $image->getClientOriginalName()));
                    $path_name = time() . $file_name . '.' . $extention;
                    $image->move($uploadPath, $path_name);

                    $this->imageRepository->create(
                        [
                            'product_id' => $product_id,
                            'product_img' => $path_name
                        ]
                    );
                }
            }
            if ($request['sizes']) {
                $sizes = $request['sizes'];
                foreach ($sizes as $size) {
                    AttributeProduct::create([
                        'product_id' => $product_id,
                        'attribute_value_id' => $size
                    ]);
                }
            }
            if ($request['colors']) {
                $colors = $request['colors'];
                foreach ($colors as $color) {
                    AttributeProduct::create([
                        'product_id' => $product_id,
                        'attribute_value_id' => $color
                    ]);
                }
            }
            DB::commit();
            Notify::success('Thêm sản phẩm thành công', $title = null, $options = []);
        } catch (\throwable $th) {
            throw $th;
            Notify::error('Thêm sản phẩm thất bại', $title = null, $options = []);
            DB::rollback();
        }
    }

    public function deleteProduct($id)
    {
        try {
            $this->productRepository->delete($id);
            Notify::success('Xóa sản phẩm thành công', $title = null, $options = []);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            Notify::error('Xóa sản phẩm thất bại', $title = null, $options = []);
        }
    }
    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }
    public function updateProduct(array $data, $id)
    {
        // try {
        $array = [];
        $product = Product::find($id);
        $data2 = DB::table('category_products as cp')
            ->join('categories as c', 'c.id', '=', 'cp.category_id')
            ->join('products as p', 'p.id', '=', 'cp.product_id')
            ->where('p.id', '=', $id)
            ->select('c.id')
            ->get()
            ->keyBy('id')
            ->toArray();
        // dd($data);
        $categories = $data['categories'];
        $new_colors = $data['colors'];
        $new_sizes = $data['sizes'];

        foreach ($data2 as $key => $value) {
            $array[] = $key;
        }

        foreach ($array as $value) {
            if (!in_array($value, $categories)) {
                // echo $value;
                $product->categories->detach($value);
            }
        }
        foreach ($categories as $category) {
            if (!in_array($category, $array)) {
                // echo "chua co danh muc do" . $category;
                $product->categories()->attach($category);
            }
        };
        $colors = $this->getAttributeById('color', $id);
        $sizes = $this->getAttributeById('size', $id);
        $array_color = [];
        $array_size = [];

        foreach ($colors as $key => $value) {
            $array_color[] = $key;
        }
        foreach ($sizes as $key => $value) {
            $array_size[] = $key;
        }
        foreach ($array_color as $value) {
            if (!in_array($value, $new_colors)) {
                // echo $value;
                $product->attributes->detach($value);
            }
        }
        foreach ($new_colors as $color) {
            if (!in_array($color, $array_color)) {
                // echo "chua co danh muc do" . $category;
                $product->attributes()->attach($color);
            }
        };
        foreach ($array_size as $value) {
            if (!in_array($value, $new_sizes)) {
                // echo $value;
                $product->attributes->detach($value);
            }
        }
        foreach ($new_sizes as $size) {
            if (!in_array($size, $array_size)) {
                // echo "chua co danh muc do" . $category;
                $product->attributes()->attach($size);
            }
        };
        $this->productRepository->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'quantity' => $data['quantity'],
        ], $id);
        Notify::success('Sua san pham thanh cong');
        // } catch (\Exception $e) {
        // Notify::error($e->getMessage());
        // }
    }

    public function getAttribute($params, $id)
    {
        $data = DB::table('products as p')
            ->join('attribute_products as ap', 'p.id', '=', 'ap.product_id')
            ->join('attribute_values as av', 'ap.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'a.id', '=', 'av.attribute_id')
            ->where('a.name', '=', $params)
            ->where('p.id', '=', $id)
            ->select('av.value_name')
            ->get();
        return $data;
    }
    public function getMaxQuantity()
    {
        $data = DB::table('order_details as od')
            ->join('products as p', 'od.product_id', '=', 'p.id')
            ->groupBy('od.product_id')
            ->select('od.product_id', DB::raw('SUM(od.quantity) as Số lượng đã bán'))
            ->limit(1);
        return $data;
    }
}
