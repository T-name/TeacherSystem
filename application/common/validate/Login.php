<?php

//登入数据验证类
namespace app\common\validate;

use think\Validate;

class Login extends Validate
{
    //验证规则
        protected $rule =[
            'user|账号' => [
                'require',
                'min'=>6,
                'number'
            ],
            'password|密码'=>[
                'require',
                'min'=>5,
                'alphaNum'
            ],
            'code|验证码'=>'require|captcha'
        ];

}