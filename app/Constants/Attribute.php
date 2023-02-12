<?php

namespace App\Constants;

class Attribute extends Notify
{
    const ATTRIBUTE_NAME_SIZE = 'size';
    const ATTRIBUTE_NAME_COLOR = 'color';
    const ATTRIBUTE_VALUE_LIMIT_SHOW = 15;

    private $tableName = ' Thuộc tính ';
    private $action;
    public function __construct()
    {
        parent::__construct($this->tableName, $this->action);
    }
}
