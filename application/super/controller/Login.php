<?php


namespace app\super\controller;

use think\Config;

use think\Controller;
use think\facade\Request;
use think\validate;
use think\facade\Session;

class Login extends Controller
{
    function Login(){
        if(Session::has('token')){
            return $this->success('你已经登录成功过了','/index.php/super/index/index');
        }else{
            return $this->fetch();
        }
    }

    //验证令牌秘钥
    function valiToken( \think\Request $request){
        if(!$request->isAjax()){
            return $this->success('操作失败','http://'.Request::host());
        }
        $validate = Validate::make([
            'token|口令'  => 'require',
            'key秘钥' => 'require'
        ]);
        if ($validate->check($request->post())) {
            dump($validate->getError());
            echo json_encode(['code'=>false,'meg'=>$validate->getError()]);
            return;
        }
        $token= $request->post('token');
        $key= $request->post('key');
        if($token ==Config('token.token') && $key == Config('token.key')){
            Session::set('token',md5($token));

            echo json_encode(['code'=>true,'meg'=>'登录成功']);
        }else{
            echo json_encode(['code'=>false,'meg'=>"登录失败"]);
        }
    }

    //退出操作
    function quit(){
        Session::delete('token');
        if(!Session::has('token')){
            return $this->success('退出成功','http://'.Request::host());
        }
    }
}