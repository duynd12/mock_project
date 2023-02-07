<?php

namespace App\Services;

use App\Models\AttributeProduct;
use App\Models\Product;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Helmesvs\Notify\Facades\Notify as Notify;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\Nop;

class ProductService
{

    private $productRepository;
    private $imageRepository;
    private $orderRepository;


    public function __construct(
        ProductRepository $_productRepository,
        ImageRepository $_imageRepository,
    ) {
        $this->productRepository = $_productRepository;
        $this->imageRepository = $_imageRepository;
    }
    public function getSumOrder()
    {
        $sum = 0;
        $total_price = $this->orderRepository->getFieldTotalPrice();
        foreach ($total_price as $price) {
            $sum += $price;
        }

        return $sum;
    }
    public function updateCategory($id, $categories)
    {

        $product = Product::find($id);

        // foreach ($this->getCategoryId($id) as $value) {
        //     if (!in_array($value, $categories)) {
        //         $product->categories()->detach($value);
        //     }
        // }
        // foreach ($categories as $category) {
        //     if (!in_array($category, $this->getCategoryId($id))) {
        //         $product->categories()->attach($category);
        //     }
        // };

        foreach ($this->getIdCateOrProduct('category', $id) as $value) {
            if (!in_array($value, $categories)) {
                $product->categories()->detach($value);
            }
        }
        foreach ($categories as $category) {
            if (!in_array($category, $this->getIdCateOrProduct('category', $id))) {
                $product->categories()->attach($category);
            }
        };
    }


    public function getAttributeById($params, $id)
    {
        $array = [];
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
        foreach ($data as $key => $value) {
            $array[] = $key;
        }
        return $array;
    }

    public function upLoadImage($images, $product_id)
    {
        $uploadPath = 'storage/uploads/';
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
    public function createAttributeProduct($data, $product_id)
    {
        foreach ($data as $attr) {
            AttributeProduct::create([
                'product_id' => $product_id,
                'attribute_value_id' => $attr
            ]);
        }
    }
    public function createProduct($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->only(['name', 'price', 'description', 'quantity']);
            $reslut = $this->productRepository->create($data);
            $product_id = $reslut->id;

            if ($request['categories']) {
                $this->updateCategory($product_id, $request['categories']);
            }
            if ($request->hasfile('images')) {
                $this->upLoadImage($request->file('images'), $product_id);
            }
            if ($request['sizes']) {
                $sizes = $request['sizes'];
                $this->createAttributeProduct($sizes, $product_id);
            }
            if ($request['colors']) {
                $colors = $request['colors'];
                $this->createAttributeProduct($colors, $product_id);
            }

            DB::commit();
            Notify::success('Thêm sản phẩm thành công', $title = null, $options = []);
        } catch (\throwable $th) {
            throw $th;
            Notify::error('Thêm sản phẩm thất bại', $title = null, $options = []);
            DB::rollback();
        }
    }
    public function deleteImage($image)
    {
        $image_path = public_path('storage/uploads/' . $image->product_img);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
    }
    public function deleteProduct($id)
    {
        try {
            $product = $this->productRepository->find($id);
            foreach ($product->images as $image) {
                $this->deleteImage($image);
            }
            $this->productRepository->delete($id);
            $product->categories()->detach($id);
            $product->attributes()->detach($id);

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

    // 11h00 7022023
    // public function getArrayAttribute($attr, $id)
    // {
    //     $array = [];

    //     $data = $this->getAttributeById($attr, $id);

    //     foreach ($data as $key => $value) {
    //         $array[] = $key;
    //     }
    //     return $array;
    // }

    // 7/02/2023 test
    public function getIdCateOrProduct($keyword, $id)
    {
        $array = [];

        if ($keyword == 'product') {
            $id_where = 'c.id';
            $id_select = 'p.id';
        }
        if ($keyword == 'category') {
            $id_where = 'p.id';
            $id_select = 'c.id';
        }
        $array_id = DB::table('category_products as cp')
            ->join('categories as c', 'c.id', '=', 'cp.category_id')
            ->join('products as p', 'p.id', '=', 'cp.product_id')
            ->where($id_where, '=', $id)
            ->select($id_select)
            ->get()
            ->keyBy('id')
            ->toArray();

        foreach ($array_id as $key => $value) {
            $array[] = $key;
        }
        // dd($array);
        return $array;
    }
    // public function getProductId($id)
    // {
    //     $array = [];
    //     $category_id = DB::table('category_products as cp')
    //         ->join('categories as c', 'c.id', '=', 'cp.category_id')
    //         ->join('products as p', 'p.id', '=', 'cp.product_id')
    //         ->where('c.id', '=', $id)
    //         ->select('p.id')
    //         ->get()
    //         ->keyBy('id')
    //         ->toArray();

    //     foreach ($category_id as $key => $value) {
    //         $array[] = $key;
    //     }

    //     return $array;
    // }

    // public function getCategoryId($id)
    // {
    //     $array = [];
    //     $category_id = DB::table('category_products as cp')
    //         ->join('categories as c', 'c.id', '=', 'cp.category_id')
    //         ->join('products as p', 'p.id', '=', 'cp.product_id')
    //         ->where('p.id', '=', $id)
    //         ->select('c.id')
    //         ->get()
    //         ->keyBy('id')
    //         ->toArray();

    //     foreach ($category_id as $key => $value) {
    //         $array[] = $key;
    //     }

    //     return $array;
    // }

    public function updateAttribute($id, $array_attr, $new_attr)
    {

        $product = Product::find($id);
        foreach ($array_attr as $value) {
            if (!in_array($value, $new_attr)) {
                $product->attributes()->detach($value);
            }
        }
        foreach ($new_attr as $value) {
            if (!in_array($value, $array_attr)) {
                $product->attributes()->attach($value);
            }
        };
    }
    public function updateProduct(array $data, $id)
    {
        try {
            DB::beginTransaction();
            $array_size = $this->getAttributeById('size', $id);
            $array_color = $this->getAttributeById('color', $id);
            if (isset($data['categories'])) {
                $this->updateCategory($id, $data['categories']);
            };
            if (isset($data['sizes'])) {
                $this->updateAttribute($id, $array_size, $data['sizes']);
            };
            if (isset($data['colors'])) {
                $this->updateAttribute($id, $array_color, $data['colors']);
            };
            if (isset($data['images'])) {
                $this->upLoadImage($data['images'], $id);
            }

            $this->productRepository->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'quantity' => $data['quantity'],
            ], $id);
            DB::commit();
            Notify::success('Sua san pham thanh cong');
        } catch (\Exception $e) {
            DB::commit();
            Notify::success($e->getMessage());
        }
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