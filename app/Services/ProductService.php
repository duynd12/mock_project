<?php

namespace App\Services;

use App\Constants\Product as ProductConstants;
use App\Models\AttributeProduct;
use App\Models\Product;
use App\Repositories\ImageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Helmesvs\Notify\Facades\Notify as Notify;
use Illuminate\Support\Facades\File;
use App\Constants\Notify as NotifyConstants;

class ProductService
{

    private $productRepository;
    private $imageRepository;
    private $orderRepository;
    private $productConstants;



    public function __construct(
        ProductRepository $_productRepository,
        ImageRepository $_imageRepository,
        OrderRepository $_orderRepository,
        ProductConstants $_productConstants
    ) {
        $this->productRepository = $_productRepository;
        $this->imageRepository = $_imageRepository;
        $this->orderRepository = $_orderRepository;
        $this->productConstants = $_productConstants;
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

        $product = $this->productRepository->find($id);

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
        $this->productConstants->setHandle(NotifyConstants::ADD);
        try {
            DB::beginTransaction();
            $data = $request->only(['name', 'price', 'description', 'quantity', 'discount']);
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
            Notify::success($this->productConstants->getNotifySuccess());
        } catch (\throwable $th) {
            throw $th;
            Notify::error($this->productConstants->getNotifyError(), $title = null, $options = []);
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
        $this->productConstants->setHandle(NotifyConstants::DELETE);

        try {
            $product = $this->productRepository->find($id);
            foreach ($product->images as $image) {
                $this->deleteImage($image);
            }
            $this->productRepository->delete($id);
            $product->categories()->detach($id);
            $product->attributes()->detach($id);

            Notify::success($this->productConstants->getNotifySuccess(), $title = null, $options = []);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            Notify::error($this->productConstants->getNotifyError(), $title = null, $options = []);
        }
    }
    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }

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
        $array_id = $this->getJoinTableCategory()
            ->where($id_where, '=', $id)
            ->select($id_select)
            ->get()
            ->keyBy('id')
            ->toArray();

        foreach ($array_id as $key => $value) {
            $array[] = $key;
        }
        return $array;
    }
    public function getJoinTableCategory()
    {
        $data =  DB::table('category_products as cp')
            ->join('categories as c', 'c.id', '=', 'cp.category_id')
            ->join('products as p', 'p.id', '=', 'cp.product_id');

        return $data;
    }

    public function getProductName($id)
    {
        $data = $this->getJoinTableCategory()
            ->where('c.id', '=', $id)
            ->select('p.id', 'p.name')
            ->get()
            ->toArray();
        return $data;
    }

    public function getCustomerBuyMax()
    {
        $customer_buy = DB::table('orders')
            ->select('user_id', DB::raw('SUM(total_price) as total_spending'))
            ->groupBy('user_id')
            ->orderBy('total_spending', 'desc')
            ->first();

        return $customer_buy;
    }
    public function getCustomerBuyInfo($data)
    {

        $customer_buy_info = DB::table('users as u')
            ->join('profiles as p', 'p.user_id', '=', 'u.id')
            ->where('id', $data->user_id)
            ->first();

        return $customer_buy_info;
    }

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
        $this->productConstants->setHandle(NotifyConstants::UPDATE);
        try {
            DB::beginTransaction();
            $array_size = $this->getAttributeById('size', $id);
            $array_color = $this->getAttributeById('color', $id);
            $categories = [];
            $sizes = [];
            $colors = [];
            $images = [];
            if (isset($data['categories'])) {
                $categories = $data['categories'];
            };
            $this->updateCategory($id, $categories);

            if (isset($data['sizes'])) {
                $sizes = $data['sizes'];
            };
            $this->updateAttribute($id, $array_size, $sizes);
            if (isset($data['colors'])) {
                $colors = $data['colors'];
            };
            $this->updateAttribute($id, $array_color, $colors);
            if (isset($data['images'])) {
                $images = $data['images'];
            }
            $this->upLoadImage($images, $id);

            $this->productRepository->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'discount' => $data['discount'],
            ], $id);
            DB::commit();
            Notify::success($this->productConstants->getNotifySuccess());
        } catch (\Exception $e) {
            DB::commit();
            Notify::error($e->getMessage());
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
