<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\Interfaces\AttributeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{
    public function __construct(Attribute $model)
    {
        parent::__construct($model);
    }
    public function getAttributeValue($param)
    {
        $data = DB::table('attributes')
            ->join('attribute_values', 'attributes.id', '=', 'attribute_values.attribute_id')
            ->where('attributes.name', '=', $param)
            ->select('attribute_values.id', 'attributes.name', 'attribute_values.value_name')
            ->get();

        return $data;
    }
}
