<?php


namespace app\common\validate;

use think\validate;

class File extends Validate
{
    protected $rule =[
        'i_sid|学号'=>'require|alphaNum|min:6|max:24',
        'c_studentname|姓名'=>'require|max:128|min:2',
        'i_classid|班级id'=>'require|number|max:20|min:5',   //班级id必须为无符号数字
        'i_phone_number|手机号'=>'require|mobile',
        'i_parent_phone|家长手机号'=>'require|mobile',
        'v_home_address|家庭地址'=>'require|min:2|max:128',

    ];

}