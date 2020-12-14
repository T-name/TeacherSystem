<?php

//签到控制器
namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\SyClass;
use app\common\model\SyGroup;
use app\common\model\SyNote;
use app\common\model\SyStatus;
use app\common\model\SyStudent;
use think\Db;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;
use think\Validate;

class Call extends Base
{

    function initialize()
    {
        $this->isIndex();
    }

    function classlist(){
        $this->vali();

        return $this->fetch();
    }

    //classlist页面班级信息初始化
    function json(){
        $this->vali();
        $this->isAjax();
      $data = SyGroup::where('i_teacherid',Session::get('user.id'))->field('i_classid')->select();
      if(count($data)){
          for($i=0;$i<count($data);$i++){
              $result[$i]['classid'] = $data[$i]['i_classid'];
              $result[$i]['classname'] = SyClass::where('i_classid',$data[$i]['i_classid'])->field('v_classname')->find()['v_classname'];
              $result[$i]['classlength'] = count(SyStudent::where('i_classid',$data[$i]['i_classid'])->select());
          }
          echo json_encode(['code'=>true,"res"=>$result]);
      }else{
          echo json_encode(['code'=>false,"msg"=>"当前帐号暂无管理班级"]);
      }
    }

    //页面渲染
    function view (){
        $this->vali();
        Cookie::set('classid',Request::param()['classid']);  //进入班级设置班级id
       return $this->fetch();
    }

    //    json返回数据班级成员
    function member(){
        $this->vali();
        $this->isAjax();
        $classid = Cookie::get('classid');
        $note = SyNote::where('i_sid','in',function ($query) use($classid){
            $query->table('sy_student')->where('i_classid', $classid)->field('i_sid');
        })->field('v_order_number,i_sid,v_note_info,create_time,end_time')->select();

        $isClass = SyGroup::where(["i_classid"=>$classid,"i_teacherid"=>Session::get("user.id")])->find();
        if($isClass){
            $note = SyNote::where('i_sid','in',function ($query) use($classid){
                $query->table('sy_student')->where('i_classid', $classid)->field('i_sid');
            })->where('end_time', '> time', time())->field('v_order_number,i_sid,v_note_info,create_time,end_time')->select();
            $db_classinfo = SyStudent::where('i_classid',$classid)->where("")->field('i_sid,c_studentname')->select();
            if(count($db_classinfo)){
                for ($i=0;$i<count($db_classinfo);$i++){
                    $classinfo[$i]["sid"] = $db_classinfo[$i]['i_sid'];
                    $classinfo[$i]["name"] = $db_classinfo[$i]['c_studentname'];
                }

                for($i=0;$i<count($note);$i++){
                   for ($j=0;$j<count($classinfo);$j++){
                        if($note[$i]['i_sid'] == $classinfo[$j]['sid']){
                               $classinfo[$j]['note'][$i]['number']=$note[$i]['v_order_number'];
                               $classinfo[$j]['note'][$i]['mseeage']=$note[$i]['v_note_info'];
                               $classinfo[$j]['note'][$i]['create']=$note[$i]['create_time'];
                               $classinfo[$j]['note'][$i]['end']=date('Y-m-d H:i:s',$note[$i]['end_time']);
                        }
                   }
                }
                echo json_encode(['code'=>true,"res"=>$classinfo]);
            }else{
                echo json_encode(['code'=>false,"msg"=>"该班级无成员信息"]);
            }
        }else{
            echo json_encode(['code'=>false,"msg"=>"你无权限管理该班级"]);
        }
    }

    //签到数据接收
    function  getPost(){
        $this->vali();
        $this->isAjax();
        $post = Request::param();
        $key =array_keys($post);
        $teacherid= Session::get('user.id');
        if(Request::isAjax()){
            $status = new SyStatus();
            $list = [];
            for($i=0;$i<count($key);$i++){
                if(!SyGroup::where('i_classid',SyStudent::where('i_sid',str_replace("status","",$key[$i]))->field('i_classid')->find()['i_classid'])->where('i_teacherid',$teacherid)->find()){
                    $list = [];
                    echo json_encode(['code'=>false,'meg'=>'学号'.str_replace("status","",$key[$i]).'签到失败 数据疑似被篡改 请刷新页面重新签到']);
                    return;
                }
                if(!in_array($post[$key[$i]],['1','2','3','4','5','6'])){
                    $list = [];
                    echo json_encode(['code'=>false,'meg'=>'学号'.str_replace("status","",$key[$i]).'签到状态不允许 数据疑似被篡改 请刷新页面重新签到']);
                    return;
                }
                array_push($list,['i_sid'=>str_replace("status","",$key[$i]),'c_status'=>$post[$key[$i]],'c_checkid'=>$teacherid]);
            }
            $bool = $status->saveAll($list);
            if(count($bool) == count($bool)){
                echo json_encode(['code'=>true,'meg'=>'签到成功']);
            }else{
                echo json_encode(['code'=>false,'meg'=>'签到失败']);
            }
        }else{
           $this->isAjax();
        }
    }

    //返回一个班级名称
    function className(){
        $this->vali();
        $this->isAjax();
        $classid = Cookie::get('classid');
        $isClass = SyGroup::where(["i_classid"=>$classid,"i_teacherid"=>Session::get("user.id")])->find();
        if($isClass){
            $classname= SyClass::where('i_classid',$classid)->field('v_classname')->find()['v_classname'];
            echo json_encode(["code"=>true,'calssname'=>$classname]);
        }else{
            echo json_encode(["code"=>false,"msg"=>"该班级你无权限访问"]);
        }
    }

}