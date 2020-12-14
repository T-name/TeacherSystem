<?php


namespace app\admin\controller;

use app\common\controller\Base;
use app\common\model\SyClass;
use app\common\model\SyStatus;
use app\common\model\SyStudent;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\validate;

class Check extends Base
{
        function view(){
            //渲染输出
            if(count(SyClass::where('i_headmasterid',Session::get('user.id'))->select())){
                return $this->fetch();
            }else{
                return  $this->error('当前帐号暂无数据');
            }
        }

        //班级输出
        function class(){
           $this->isAjax();
           $this->vali();
           $db_class= SyClass::where('i_headmasterid',Session::get('user.id'))->select();
           for ($i=0;$i<count($db_class);$i++){
               $class[$i]['classid'] = $db_class[$i]['i_classid'];
               $class[$i]['classname'] = $db_class[$i]['v_classname'];
           }
           echo json_encode($class);
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
                'length|数据长度'=>'require|number',
            ]);
            if (!$validate->check(Request::param())) {
                echo json_encode(['tips'=>$validate->getError()]);
                return;
            }
            $start_time = Request::param('start_time')?strtotime(Request::param('start_time')):strtotime("2020-01-01"); //开始时间 默认从2020年1月1号开始
            $end_time =Request::param('end_time')?strtotime(Request::param('end_time')):time(); //结束时间
            $student_id =Request::param('student_id'); //学号
            $status =Request::param('status'); //状态
            $class_id =Request::param('class_id'); //班级id
            $page = Request::param()['page']; //页码
            $length = Request::param()['length']; //每页长度
            $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE student.i_classid = "'. $class_id .'" AND c_status = "'. $status .'" AND sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid WHERE i_sid = '. '"' .$student_id.'"';
            
            //班级id和学号都缺少
            if($class_id == "" && $student_id == "" && $status == "0"){  //学号，状态，班级 为空的情况
                $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid';
            }elseif ($class_id == "" && $student_id == ""){  //班级，学号为空的情况
                $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE c_status = "'. $status .'" AND sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid';
            }elseif ($student_id == "" && $status == "0"){ //学号，状态为空
                $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE student.i_classid = "'. $class_id .'" AND sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid';
            }elseif ($class_id == "" && $status == "0"){  //班级，状态为空
                $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid WHERE i_sid = '. '"' .$student_id.'"';
            }elseif ($student_id == ""){   //学号缺少
                $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE student.i_classid = "'. $class_id .'" AND c_status = "'. $status .'" AND sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid';
            }elseif ($class_id == ""){    //班级id缺少
                $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE c_status = "'. $status .'" AND sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid WHERE i_sid = '. '"' .$student_id.'"';
            }elseif ($status == "0") {  //状态缺少
                $sql= 'SELECT temp.i_sid,temp.c_status,sy_class.v_classname,temp.create_time,temp.update_time FROM (SELECT sy_status.i_sid,sy_status.c_status,student.i_classid,sy_status.create_time,sy_status.update_time FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '. Session::get('user.id') .')) as student  on student.i_sid = sy_status.i_sid WHERE student.i_classid = "'. $class_id .'" AND sy_status.update_time BETWEEN '.$start_time .' AND '. $end_time .') as temp INNER JOIN sy_class ON temp.i_classid = sy_class.i_classid WHERE i_sid = '. '"' .$student_id.'"';
            }

            $temp= Db::query($sql.' LIMIT '.(($page-1)*$length).','.$length);

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

        /**
         * 修改记录
         */
        function modify(){
           $this->vali();
           $this->isAjax();
           $sid =  Request::param()['sid'];
           $start =  Request::param()['start'];
           $end =  Request::param()['end'];
           if($sid !="" && $start !="" && $end != ""){
                if(strtotime($start) < strtotime($end)){
                  if(SyClass::where('i_classid',SyStudent::where('i_sid',$sid)->find()['i_classid'])->where('i_headmasterid',Session::get('user.id'))->find()){
                      $temp_res = SyStatus::where('i_sid',$sid)->where('create_time', 'between time', [$start, $end])->select();
                      if(count($temp_res)){
                          for($i=0;$i<count($temp_res);$i++){
                              $res[$i]['id'] = $temp_res[$i]['id'];  //id
                              $res[$i]['sid'] = $temp_res[$i]['i_sid']; //学号
                              $res[$i]['tid'] = $temp_res[$i]['c_checkid'];  //签到人id
                              $res[$i]['status'] = $temp_res[$i]['c_status'];  //签到状态
                              $res[$i]['create_time'] = $temp_res[$i]['create_time']; //签到时间
                          }
                          echo json_encode(['code'=>true,'res'=>$res]);
                      }else{
                          echo json_encode(['code'=>false,'meg'=>'未查询到记录']);
                      }
                  }else{
                      echo json_encode(['code'=>false,'meg'=>'该学你无法修改']);
                  }
                }else{
                    echo json_encode(['code'=>false,'meg'=>'开始时间不能大于结束时间']);
                }
           }
        }

        //开始修改
        function actionModify(){
            $data = json_decode(Request::param()['data'],true);
            if(count($data)){
                $validate = Validate::make([
                    'id'  => 'require|max:25',
                    'sid|学号' => 'require|alphaNum|max:25|min:6',
                    'tid|签到人' => 'require|number|max:25|min:5',
                    'time|日期' => 'require|date',
                    'status|状态' => 'require|in:1,2,3,4,5,6'
                ]);
                for($i=0;$i<count($data);$i++){
                    //数据验证
                    if (!$validate->check($data[$i])) {
                        echo json_encode(['code'=>false,'meg'=>$validate->getError().'请勿违规操作']);
                        return;
                    }
                    //权限验证
                    $db_tid = SyClass::where('i_classid',SyStudent::where('i_sid',$data[$i]['sid'])->field('i_classid')->find()['i_classid'])->where('i_headmasterid',Session::get('user.id'))->find();
                    if(!$db_tid){
                        echo json_encode(['code'=>false,'meg'=>'学号为：'.$data[$i]['sid'].'的学生不在你所管理范围内']);
                        return;
                    }

                    //状态是否修改
                    $db_status = SyStatus::where([
                        'id'=>$data[$i]['id'],
                        'i_sid'=>$data[$i]['sid'],
                        'c_checkid'=>$data[$i]['tid'],
                        'create_time'=>strtotime($data[$i]['time'])
                    ])->find()->getData()['c_status'];
                   if($db_status == $data[$i]['status']){
                       echo json_encode(['code'=>false,'meg'=>'时间为：'.$data[$i]['time'].'的学生状态数据未修改']);
                       return;
                   }
                }

                //循环修改
                $res = [];
                for($i=0;$i<count($data);$i++){
                    $temp_res = SyStatus::where([
                        'id'=>$data[$i]['id'],
                        'i_sid'=>$data[$i]['sid'],
                        'c_checkid'=>$data[$i]['tid'],
                        'create_time'=>strtotime($data[$i]['time'])
                    ])->update(['c_status'=>$data[$i]['status']]);
                    if($temp_res){
                        array_push($res,'时间为：'.$data[$i]['time'].'的状态更新成功');
                    }else{
                        array_push($res,'时间为：'.$data[$i]['time'].'更新失败 请尝试重新修改');
                    }
                }
                if(count($res)){
                    echo  json_encode(['code'=>true,'res'=>$res]);
                }else{
                    echo  json_encode(['code'=>true,'meg'=>'修改失败']);
                }

            }else{
                echo json_encode(['code'=>false,'meg'=>'数据为空']);
            }
        }
}