<?php


namespace app\admin\controller;

/**
 * Json控制器
 *
 */

use app\common\controller\Base;
use app\common\model\SyClass;
use think\facade\Session;

class Json extends Base
{
    /*
        *把班级用json方式返回
        */
    function json(){
        $this->vali();
        $classlist = SyClass::where('i_headmasterid',Session::get('user.id'))->field('i_classid,v_classname')->select();
        echo json_encode($classlist);
    }
}