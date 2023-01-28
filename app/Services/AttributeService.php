<?php

namespace App\Services;

use App\Repositories\AttributeRepository;
use Helmesvs\Notify\Facades\Notify;

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
}
