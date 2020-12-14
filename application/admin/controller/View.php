<?php
    //班级列表

namespace app\admin\controller;
use app\common\controller\Base;
use think\facade\Session;
use app\common\model\SyClass;
use app\common\model\SyStudent;

class View extends  Base
{
    function classview(){
        $this->vali();
        $this->isModule();  //判断是不是该模块操作
        $id= Session::get('user.id');
        $class =SyClass::where('i_headmasterid',$id)->select();
        $data =[];
       for($i=0;$i<count($class);$i++){
           $data[$i]['classname'] = $class[$i]['v_classname'];
           $data[$i]['length'] = count(SyStudent::where('i_classid',$class[$i]['i_classid'])->select());
           $data[$i]['classid']=$class[$i]['i_classid'];
       }
        if(count($data)){
            return $this->fetch('classview',['classinfo'=>$data]);
        }else{
            return  $this->error('当前帐号暂无数据');
        }
    }
}