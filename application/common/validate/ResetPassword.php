<?php


namespace app\common\validate;

use think\Validate;

class ResetPassword extends Validate
{
    protected $rule =[
        'reset_password|密码' => [
            'require',
            'min'=>6,
            'max'=>32,
            'alphaNum'
        ],
        'user_id'=>[
            'require',
            'number'
        ]
    ];
}