<?php

namespace App\Constants;

class Product extends Notify
{
    const PRODUCT_LIST_LIMIT = 8;
    const PRODUCT_VALUE_SIZE = 'size';
    const PRODUCT_VALUE_COLOR = 'color';
    const ATTRIBUTE_ARRAY_NAME_SIZE = 'sizes';
    const ATTRIBUTE_ARRAY_NAME_COLOR = 'colors';

    private $tableName = 'sản phẩm';
    private $action;
    public function __construct()
    {
        parent::__construct($this->tableName, $this->action);
    }
}
