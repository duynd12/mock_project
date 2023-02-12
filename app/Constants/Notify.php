<?php

namespace App\Constants;

use Exception;

class Notify
{

    protected $table_name;
    protected $handle;
    const ADD = 'Thêm ';
    const UPDATE = 'Sửa ';
    const DELETE = 'Xóa ';


    public function __construct($_table_name, $_handle)
    {
        $this->table_name = $_table_name;
        $this->handle = $_handle;
    }
    public function setHandle($action)
    {
        switch ($action) {
            case self::ADD:
                $this->handle = self::ADD;
                break;
            case self::UPDATE:
                $this->handle = self::UPDATE;
                break;
            case self::DELETE:
                $this->handle = self::DELETE;
                break;
            default:
                throw new Exception;
        };
    }
    public function getNotifySuccess()
    {
        return  $this->handle . $this->table_name . ' thành công';
    }
    public function getNotifyError()
    {
        return $this->handle  . $this->table_name . ' thất bại';
    }
}
