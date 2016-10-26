<?php

namespace App\Models;

use App\Library\Medoo;

class BaseModel extends Medoo
{
    protected $table = '';

    protected $allow_field = [];

    //过滤数据库没有的字段
    public function filter_field(&$data)
    {
        if (!is_array($this->allow_field) || !$this->allow_field) {
            return false;
        }

        $new_data = [];
        foreach ($this->allow_field as $v) {
            if (isset($data[$v])) {
                $new_data[$v] = $data[$v];
            }
        }

        return $new_data;
    }
}
