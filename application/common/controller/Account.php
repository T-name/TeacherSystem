<?php
namespace app\common\controller;

use app\common\model\SyTeacher;
use think\facade\Session;

class Account
{
    function  info(){
        $accountid = Session::get('user.id');
       $info=   SyTeacher::where('i_headmasterid',$accountid)->field('v_headmastername,i_state')->find();
      return $info;
    }
}