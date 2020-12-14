<?php

//教师名单表
namespace app\common\model;

use think\Model;

class SyTeacher extends Model
{
    protected $autoWriteTimestamp = true;
    public function getiStateAttr($value)
    {
        $status = [0=>'普通管理员',1=>'超级管理员'];
        return $status[$value];
    }

}