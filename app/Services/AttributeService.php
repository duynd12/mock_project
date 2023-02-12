<?php

namespace App\Services;

use App\Repositories\AttributeRepository;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Support\Facades\DB;
use App\Constants\Notify as NotifyConstants;
use App\Constants\Attribute as AttributeConstants;

class AttributeService
{
    private $attributeRepository;
    private $attributeConstants;

    public function __construct(AttributeRepository $_attributeRepository, AttributeConstants $_attributeConstants)
    {
        $this->attributeRepository = $_attributeRepository;
        $this->attributeConstants = $_attributeConstants;
    }
    public function createAttribute($request)
    {
        $this->attributeConstants->setHandle(NotifyConstants::ADD);
        try {
            $data = $request->all();
            $this->attributeRepository->create($data);
            Notify::success($this->attributeConstants->getNotifySuccess());
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }

    public function deleteAttribute($id)
    {
        $this->attributeConstants->setHandle(NotifyConstants::DELETE);
        try {
            $this->attributeRepository->delete($id);
            Notify::success($this->attributeConstants->getNotifySuccess());
        } catch (\Exception $e) {
            Notify::error($e->getMessage());
        }
    }

    public function updateAttribute($request, $id)
    {
        $this->attributeConstants->setHandle(NotifyConstants::UPDATE);
        try {
            $data = $request->all();
            $this->attributeRepository->update(
                [
                    'name' => $data['name'],
                ],
                $id
            );
            Notify::success($this->attributeConstants->getNotifySuccess());
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
