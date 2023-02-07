<?php

namespace App\Services;

use App\Repositories\AttributeRepository;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Support\Facades\DB;

class AttributeService
{
    private $attributeRepository;

    public function __construct(AttributeRepository $_attributeRepository)
    {
        $this->attributeRepository = $_attributeRepository;
    }
    public function createAttribute($request)
    {
        try {
            $data = $request->all();
            $this->attributeRepository->create($data);
            Notify::success('Them thanh cong');
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }

    public function deleteAttribute($id)
    {
        try {
            $this->attributeRepository->delete($id);
            Notify::success('Xóa thành công');
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }

    public function updateAttribute($request, $id)
    {
        try {
            $data = $request->all();
            $this->attributeRepository->update(
                [
                    'name' => $data['name'],
                ],
                $id
            );
            Notify::success('Sửa tên thuộc tính thành công');
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }

    public function getValueNameAttr($attr_name)
    {
        $data = DB::table('attribute_values as av')
            ->join('attributes as a', 'av.attribute_id', '=', 'a.id')
            ->where('a.name', '=', $attr_name)
            ->select('av.id', 'av.value_name')
            ->get();

        return $data;
    }

    public function getAttributeByIdPRoduct($id, $attr_name)
    {
        $data =  DB::table('products as p')
            ->join('attribute_products as ap', 'p.id', '=', 'ap.product_id')
            ->join('attribute_values as av', 'ap.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'a.id', '=', 'av.attribute_id')
            ->where('ap.product_id', '=', $id)
            ->where('a.name', '=', $attr_name)
            ->select('av.id', 'av.value_name')
            ->get();

        return $data;
    }
}