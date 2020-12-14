<?php


namespace app\index\controller;


use app\common\controller\Base;
use app\common\model\SyTeacher;
use app\common\validate\ResetPassword;
use think\facade\Request;
use think\facade\Session;

class Account extends Base
{
    function initialize()
    {
        $this->isIndex();
    }

    function index(){
        $this->vali();
        return $this->fetch();
    }

    function info(){
        $info =SyTeacher::where('i_headmasterid',Session::get('user.id'))->find();
        $arr['user_id']=$info['i_headmasterid'];
        $arr['name'] = $info['v_headmastername'];
        $arr['status']=$info['i_state'];
        $arr['create_time']=$info['create_time'];

       echo json_encode($arr);
    }

    /**s
     * 修改密码
     */
    function reset(){
        $this->vali();
        $user_id = Request::param()['user_id'];  //获取用户id
        $reset_password= md5(md5(Request::param()['reset_password'])); //获取需要修改的密码
        /**
         * 验证密码是否可行
         */
        $validat = new ResetPassword();

        if($validat->check(Request::param()) && $user_id == Session::get('user.id')){
            $is_reset = SyTeacher::where('i_headmasterid',$user_id)->update(['v_password'=>$reset_password]);  //通过模型修改密码
            echo json_encode(['reselt'=>$is_reset]);
        }else{
            echo json_encode(['reselt'=>'2','message'=> $validat->getError()]);
          
            
        }
    }
}