<?php


namespace app\common\facade;


use think\Facade;

class Quit extends Facade
{
    protected static function getFacadeClass()
    {

        return "app\common\controller\Quit";
    }
}