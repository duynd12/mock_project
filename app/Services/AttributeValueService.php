<?php

namespace App\Services;

use App\Repositories\AttributeValueRepository;

class AttributeValueService
{
    private $attributeValueRepository;
    public function __construct(AttributeValueRepository $_attrbuteValueRepository)
    {
        $this->attributeValueRepository = $_attrbuteValueRepository;
    }
}
