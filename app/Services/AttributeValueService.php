<?php

namespace App\Services;

use App\Repositories\AttributeValueRepository;
use Helmesvs\Notify\Facades\Notify;

class AttributeValueService
{
    private $attributeValueRepository;
    public function __construct(AttributeValueRepository $_attrbuteValueRepository)
    {
        $this->attributeValueRepository = $_attrbuteValueRepository;
    }
    public function createAttrValue($request, $id)
    {
        $data = $request['value_name'];
        try {
            $this->attributeValueRepository->create(
                [
                    'attribute_id' => $id,
                    'value_name' => $data
                ]
            );
            Notify::success("Thêm value thuộc tính thành công");
        } catch (\Exception $e) {
            Notify::success($e->getMessage());
        }
    }

    public function updateAttrValue($request, $id)
    {
        $data = $request->all();
        try {
            $this->attributeValueRepository->update([
                'value_name' => $data['value_name'],
            ], $id);
            Notify::success("Sửa value thuộc tính thành công");
        } catch (\Exception $e) {
            Notify::success($e->getMessage());
        }
    }

    public function deleteAttrValue($id)
    {
        try {
            $this->attributeValueRepository->delete($id);
            Notify::success("Xóa thành công");
        } catch (\Exception $e) {
            Notify::success($e->getMessage());
        }
    }
}
