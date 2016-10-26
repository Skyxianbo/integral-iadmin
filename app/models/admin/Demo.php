<?php

namespace App\Models\Vitabee;

use App\Models\BaseModel;

// 使用方式（禁止把model注册成服务service！！！）
// php子类和父类方法同名则视为重写，所以参数数量必须一致，不得已只能add、edit替代
// $member = new Demo();
// $member -> add([
//     'a' => 1,
//     'b' => 2,
// ]);
// var_dump($member -> last_query(), $member -> error());

class Demo extends BaseModel
{
    //库名.表名
    protected $table = 'admin.demo';

    //允许的数据库的字段
    protected $allow_field = [
        'id',
    ];

    public function add($data)
    {
        return parent::insert('', $this->filter_field($data));
    }

    public function edit($data, $where)
    {
        return parent::update('', $this->filter_field($data), $where);
    }
}
