<?php


namespace app\common\validate;

use think\Validate;

class CollectText extends Validate
{
    protected $rule =[
        'number|编号'=>'require|alphaNum|max:128|min:3',
        'name|姓名'=>'require|max:64|min:2',
        'sid|学号'=>'require|alphaNum|min:6|max:24',   //班级id必须为无符号数字
        'content|内容'=>'require|max:8000|min:2',  //文本内容限制8000字
        'note|备注'=>'max:128',  //限制备注只能128个字符  比前端限制多30个字符
    ];
}