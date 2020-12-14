<?php

namespace app\common\controller;

use app\common\model\SyCollect;
use app\common\model\SyTeacher;
use think\Controller;
use think\facade\Session;
use think\facade\Request;

class Base  extends Controller
{
    //所有操作初始化
    function initialize()
    {
                $this->isModule();
    }

//    验证用户是否登入状态
    function  vali(){
        if(!Session::get('user.id')) {
                return $this->error('请先登录','http://'.Request::host());
        }
    }


    //判断是否重复登录
    function isLogin(){
        if(Session::get('user.id')){

            return $this->error('请勿重复登录');
        }
    }

    //禁止跨模块操作 该方法只能用再Admin模块
    function isModule(){
        if(!Session::get('user.original') == 1 && Request::module() == 'admin'){
           return $this->error('当前模块无权限访问',"http://".Request::host());
        }
    }

    //禁止跨模块操作 该方法只能用再模块
    function isIndex(){  //
        if(!Session::get('user.original') == 0 && Request::module() == 'index'){
            return $this->error('当前模块无权限访问',"http://".Request::host());
        }
    }


    /**
     * 判断是否Ajax请求
     */
    function isAjax(){
        if(!Request::isAjax()){
            return $this->error('操作不正确' );
        }
    }


    //    退出操作
    function quit(){
        $this->vali();
        if(Session::has('user')){
            Session::delete('user');
            return $this->success('退出成功','http://'.Request::host());
        }
    }







}