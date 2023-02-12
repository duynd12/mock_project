<?php

namespace App\Constants;

class Category extends Notify
{
    private $tableName = 'category';
    private $action;

    const ARRAY_STATUS = ['Hiện', 'Ẩn'];
    const NOTIFY_ERROR = '';
    const LIMIT_SHOW = 8;
    const COLUMN_NAME = 'status';
    const STATUS_NAME = 'Hiện';
    const KEY_NAME_ARRAY = 'product_name';

    public function __construct()
    {
        parent::__construct($this->tableName, $this->action);
    }
}
