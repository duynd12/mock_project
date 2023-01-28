<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryInterface
{
    public function __construct(AttributeValue $model)
    {
        parent::__construct($model);
    }
}
