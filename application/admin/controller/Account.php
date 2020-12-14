<?php


namespace app\admin\controller;

use app\common\model\SyTeacher;
use app\common\controller\Base;
use app\common\validate\ResetPassword;
use think\facade\Session;
use think\Request;

class Account extends Base
{
    function view(){
        //dump(Session::get("user"));
        $this->vali();

//    dump(SyTeacher::where('i_headmasterid',Session::get('user.id'))->find());
        return $this->fetch();
    }

    //重置密码
    function reset(Request $request){
        $this->vali();  //验证是否登录
        $user_id = $request->param()['user_id'];  //获取用户id
        $reset_password= md5(md5($request->param()['reset_password'])); //获取需要修改的密码
        /**
         * 验证密码是否可行
         */
        $validat = new ResetPassword();

        if($validat->check($request->param()) && $user_id == Session::get('user.id')){
            $is_reset = SyTeacher::where('i_headmasterid',$user_id)->update(['v_password'=>$reset_password]);  //通过模型修改密码
            echo json_encode(['reselt'=>$is_reset]);
        }else{
            echo json_encode(['reselt'=>'2','message'=> $validat->getError()]);
        }
    }
}