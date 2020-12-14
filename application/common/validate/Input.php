<?php


namespace app\common\validate;


use think\Validate;

class Input extends Validate
{
    protected $rule =[
        'class|班级'=>'require|number|max:20|min:5',
        'name|姓名'=>'require|max:128|min:2',
        'studentid|学号'=>'require|min:6|max:24|alphaNum',
        'phone|手机号'=>'require|mobile',
        'p_phone|家长电话'=>'require|mobile',
        'address|家庭地址'=>'require|min:2|max:128',
    ];

}