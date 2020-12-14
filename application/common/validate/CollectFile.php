<?php


namespace app\common\validate;

use think\Validate;

class CollectFile extends Validate
{
    protected $rule =[
        'number|编号'=>'require|alphaNum|max:128',
        'name|姓名'=>'require|max:64|min:2',
        'sid|学号'=>'require|alphaNum|max:24|min:6',
        'note|备注'=>'max:150',  //限制备注只能128个字符  比前端限制多30个字符
    ];

}