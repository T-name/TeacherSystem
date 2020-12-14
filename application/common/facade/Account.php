<?php


namespace app\common\facade;


use think\Facade;

class Account extends Facade
{
    protected static function getFacadeClass()
    {
        return "app\common\controller\Account";
    }
}