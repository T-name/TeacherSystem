<?php


namespace app\index\controller;

//签到记录控制器

use app\common\controller\Base;
use app\common\model\SyClass;
use app\common\model\SyStatus;
use app\common\model\SyStudent;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\Validate;

class Annal extends Base
{

    function initialize()
    {
        $this->isIndex();
    }

    /**
     * 记录查询界面
     */
    function index(){
        return $this->fetch();
    }

    /**
     * 最近一次签到记录功能
     */
        function recent(){
            $this->vali();
            $this->isAjax();
            $sid = SyStatus::where('c_checkid',Session::get('user.id'))->limit(1)->order("id desc")->find()['i_sid'];
            $classname= SyClass::where('i_classid',SyStudent::where('i_sid',$sid)->find()["i_classid"])->find()['v_classname'];
            $info= SyStatus::where('c_checkid',Session::get('user.id'))->limit(count(SyStudent::where('i_classid', $classid = SyStudent::where('i_sid',$sid)->find()["i_classid"])->select()))->order("id desc")->field('i_sid,c_status,create_time,update_time')->select();

            if($sid !=null && $classname != null && $info != null){
                for($i=0;$i<count($info);$i++){
                    $info[$i]['name']=SyStudent::where('i_sid',$info[$i]['i_sid'])->field('c_studentname')->find()['c_studentname'];
                    $info[$i]['classname'] = $classname;
                }
                echo json_encode(['code'=>true,'result'=>$info]);
            }else{
                echo json_encode(['code'=>false,'result'=>'未查询到信息']);
            }
        }

    /**
     * 自定义查询功能
     */
    function diy(){
        $this->vali();
        $this->isAjax();
        $validate = Validate::make([
            'start_time|开始时间'  => 'date',
            'end_time|结束时间' => 'date',
            'student_id|学号'=>'alphaNum',
            'status|状态'=>'in:0,1,2,3,4,5,6|require',
            'class_id|班级ID'=>'number',
            'page|页码'=>'require|number',
            'length|数据长度'=>'require|number'
        ]);
        if (!$validate->check(Request::param())) {
            echo json_encode(['tips'=>$validate->getError()]);
            return;
        }
        $start_time = Request::param('start_time')?strtotime(Request::param('start_time')):strtotime("2020-01-01"); //开始时间 默认从2020年1月1号开始
        $end_time =Request::param('end_time')?strtotime(Request::param('end_time')):time(); //结束时间
        $student_id =Request::param('student_id')?'"'.Request::param('student_id').'"':""; //学号
        $status =Request::param('status'); //状态
        $class_id =Request::param('class_id'); //班级id
        $page = Request::param()['page']; //页码
        $length = Request::param()['length']; //每页长度

        $sql= 'SELECT * FROM `sy_status`  WHERE  c_checkid='.Session::get('user.id').' AND `create_time` BETWEEN '.$start_time.' AND '.$end_time;
        if($status != "0") {
            $sql = $sql.' AND c_status='.$status;
        }

        if($student_id != ""){
                $sql = $sql.' AND i_sid ='.$student_id;
        }

        //select * from sy_status inner join sy_student on sy_status.i_sid = sy_student.i_sid WHERE sy_status.c_status=1 AND sy_status.c_checkid=181260321 AND sy_student.i_classid=1812604 AND sy_status.i_sid=181260342 AND  sy_status.update_time BETWEEN 1591585320 AND 1602212520;
        if($class_id != ""){
                if($student_id != ""){
                    if($status != "0"){
                        $sql= 'select * from sy_status inner join sy_student on sy_status.i_sid = sy_student.i_sid WHERE sy_status.c_status='.$status.' AND sy_status.c_checkid='.Session::get('user.id').' AND sy_student.i_classid='.$class_id.' AND sy_status.i_sid='.$student_id.' AND  sy_status.update_time BETWEEN '.$start_time.' AND '.$end_time;
                    }else{
                        $sql= 'select * from sy_status inner join sy_student on sy_status.i_sid = sy_student.i_sid WHERE sy_status.c_checkid='.Session::get('user.id').' AND sy_student.i_classid='.$class_id.' AND sy_status.i_sid='.$student_id.' AND  sy_status.update_time BETWEEN '.$start_time.' AND '.$end_time;
                    }
                }else{
                    if($status !="0"){
                        $sql= 'select * from sy_status inner join sy_student on sy_status.i_sid = sy_student.i_sid WHERE sy_status.c_status='.$status.' AND sy_status.c_checkid='.Session::get('user.id').' AND sy_student.i_classid='.$class_id.' AND  sy_status.update_time BETWEEN '.$start_time.' AND '.$end_time;
                    }else{
                        $sql= 'select * from sy_status inner join sy_student on sy_status.i_sid = sy_student.i_sid WHERE sy_status.c_checkid='.Session::get('user.id').' AND sy_student.i_classid='.$class_id.' AND  sy_status.update_time BETWEEN '.$start_time.' AND '.$end_time;
                    }
                }
        }

        $temp =   Db::query($sql.' LIMIT '.(($page-1)*$length).','.$length); //.' LIMIT '.((1-1)*70).', 70'
            for($i=0;$i<count($temp);$i++){
                $info[$i]['name']= SyStudent::where('i_sid',$temp[$i]['i_sid'])->find()['c_studentname'];
                $info[$i]['sid'] =$temp[$i]['i_sid'];
                $info[$i]['class']= SyClass::where('i_classid',SyStudent::where('i_sid',$info[$i]['sid'])->find()['i_classid'])->find()['v_classname'];
                switch ($temp[$i]['c_status']){
                    case 1: $info[$i]['status'] ='正常';break;
                    case 2:$info[$i]['status'] ='迟到';break;
                    case 3:$info[$i]['status'] ='旷课';break;
                    case 4:$info[$i]['status'] ='早退';break;
                    case 5:$info[$i]['status'] ='请假';break;
                    case 6:$info[$i]['status'] ='其他';break;
                }
                $info[$i]['create_time'] =date( 'Y-m-d H:i:s',$temp[$i]['create_time']);
                $info[$i]['update_time'] = date('Y-m-d H:i:s',$temp[$i]['update_time']);
            }

            if($temp){
                echo json_encode([$info,'lenght'=>count(Db::query($sql))]);
            }else{
                echo json_encode(['tips'=>'未查询到该条件下的值']);
            }
    }
}

