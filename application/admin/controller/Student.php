<?php


namespace app\admin\controller;

use app\common\controller\Base;
use app\common\model\SyClass;
use app\common\model\SyGroup;
use app\common\model\SyNote;
use app\common\model\SyStatus;
use app\common\model\SyStudent;
use app\common\model\SyStudentDelete;
use think\facade\Request;
use think\facade\Session;
use think\Validate;

class Student extends Base
{
    //页面渲染
    function view(){
        $this->vali();  //验证登录
        Session::set('classid',Request::param()['classid']);
        $class= SyClass::where('i_classid',Request::param()['classid'])->field('v_classname')->find();
        $this->assign('classname',$class['v_classname']);
        //渲染页面
        return $this->fetch();
    }

    //学生信息输出接口
    function studentInfo(){
        $this->vali();
        $this->isAjax();
        $classId = Session::get('classid');  //取班级id



        /**
         * 取当前账号和当前班级数据，用于判断是否非法操作
         */
        $isbool = SyClass::where('i_classid',$classId)->where('i_headmasterid',Session::get('user.id'))->find();
        if($isbool){
            $temp_info = SyStudent::where('i_classid',$classId)->select();  //取班级数据
            if(count($temp_info)){
                for ($i=0;$i<count($temp_info);$i++){
                    $student_info[$i]['name']=$temp_info[$i]['c_studentname'];  //姓名
                    $student_info[$i]['sid']=$temp_info[$i]['i_sid'];  //学号
                    $student_info[$i]['phone_number']=$temp_info[$i]['i_phone_number'];  //手机号
                    $student_info[$i]['home_address']=$temp_info[$i]['v_home_address'];  //具体地址
                    $student_info[$i]['parent_phone']=$temp_info[$i]['i_parent_phone'];  //父母联系电话
                    $notes = SyNote::where('i_sid',$student_info[$i]['sid'])->where('i_create_id',Session::get('user.id'))->where('end_time', '> time', time())->select(); //取备注表信息
                    $student_info[$i]['note']=$notes;//$temp_info[$i]['v_note'];  //备注信息
                }
                echo json_encode(['code'=>true,'result'=>$student_info]);
            }else{
                echo json_encode(['code'=>false,'result'=>'该班级暂时没有数据']);
            }
        }else{
            $student_info['code'] =0;
            $student_info['message'] ='请勿非法操作';
           echo json_encode($student_info);
        }
    }

    //备注信息接口
    function inPost(){
        $this->vali();  //验证登录
        $this->isAjax();  //判断是ajax请求
        $data =json_decode(Request::param()['data'],true);  //解析提交过来的数据
        //$data =json_decode('[{"note_info":"好","end_time":"2020-05-13T11:21","sid":"181260330"},{"note_info":"12121","end_time":"2020-05-15T12:01","sid":"181260331"},{"note_info":"","end_time":"","sid":"181260332"},{"note_info":"好21","end_time":"2020-05-14T12:21","sid":"181260333"},{"note_info":"","end_time":"","sid":"181260334"},{"note_info":"","end_time":"","sid":"181260335"},{"note_info":"","end_time":"","sid":"181260336"},{"note_info":"","end_time":"","sid":"181260337"},{"note_info":"","end_time":"","sid":"181260338"},{"note_info":"","end_time":"","sid":"181260339"},{"note_info":"","end_time":"","sid":"1812603310"},{"note_info":"","end_time":"","sid":"1812603311"},{"note_info":"","end_time":"","sid":"1812603312"},{"note_info":"","end_time":"","sid":"1812603313"},{"note_info":"","end_time":"","sid":"1812603314"},{"note_info":"","end_time":"","sid":"1812603315"},{"note_info":"","end_time":"","sid":"1812603316"},{"note_info":"","end_time":"","sid":"1812603317"},{"note_info":"","end_time":"","sid":"1812603318"},{"note_info":"","end_time":"","sid":"1812603319"},{"note_info":"","end_time":"","sid":"1812603320"},{"note_info":"","end_time":"","sid":"1812603321"},{"note_info":"","end_time":"","sid":"1812603322"},{"note_info":"","end_time":"","sid":"1812603323"},{"note_info":"","end_time":"","sid":"1812603324"},{"note_info":"","end_time":"","sid":"1812603325"},{"note_info":"","end_time":"","sid":"1812603326"},{"note_info":"","end_time":"","sid":"1812603327"},{"note_info":"","end_time":"","sid":"1812603328"},{"note_info":"","end_time":"","sid":"1812603329"},{"note_info":"","end_time":"","sid":"1212312221"}]',true);
        $synote = new SyNote();
        $list = [];
        for($i=0;$i<count($data);$i++){
            if($data[$i]['note_info']){
                $order=date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);;
                array_push($list,['v_order_number'=>$order,'i_sid'=>$data[$i]['sid'],'i_create_id'=>Session::get('user.id'),'v_note_info'=>$data[$i]['note_info'],'end_time'=>strtotime($data[$i]['end_time'])?strtotime($data[$i]['end_time']):time()+691200]);
            }
        }

        if(!$list ==null){
            if($synote->saveAll($list)){
                echo json_encode(['result'=>true]);
            }
        }else{
            echo json_encode(['result'=>false]);
        }
    }

    //删除成员接口
    function studentDelete(){
        $this->vali();
        $this->isAjax();
        $sid =Request::param()['sid'];  //学号
        $classId = Session::get('classid'); //班级id
        $headId = Session::get('user.id');  //班主任id

        $student=SyStudent::where('i_sid',$sid)
           ->where(function () use( $headId ){
               SyGroup::where('i_classid',$headId)->find();
           })
           ->where('i_classid',$classId)
            ->field('i_sid,c_studentname,i_classid,i_phone_number,v_home_address,i_parent_phone')
           ->find();  //取学生信息

          if(!$student){
              echo  json_encode(["code"=>false,'meg'=>'删除失败 当前班级无该成员']);
              exit();
          };

        $studentDelete = new SyStudentDelete();
        //将该成员转移到另一个表中
        $create =$studentDelete->save([
            "i_sid"=>$student['i_sid'],
            "c_studentname"=>$student['c_studentname'],
            "i_classid"=>$student['i_classid'],
            "v_home_address"=>$student['v_home_address'],
            "i_phone_number"=>$student['i_phone_number'],
            "i_parent_phone"=>$student['i_parent_phone']

        ]);

        $delete=SyStudent::where('i_sid',$sid)
            ->where(function () use( $headId ){
                SyGroup::where('i_classid',$headId)->find();
            })
            ->where('i_classid',$classId)
            ->delete();

        SyStatus::where('i_sid',$sid)->delete();
        SyNote::where('i_sid',$sid)->delete();

        if($delete && $create){
             echo  json_encode(["code"=>true,'meg'=>'删除成功']);
        }else{
            echo  json_encode(["code"=>false,'meg'=>'删除失败']);
        }
    }

    //删除备注接口
    function noteDelete(){
        $this->vali();
        $this->isAjax();
       $where=[
        'i_sid'=>Request::param()['sid'],
        'v_order_number'=>Request::param()['order'],
        'i_create_id'=>Session::get('user.id'),
       ];
       $res =SyNote::where($where)->delete();
      echo json_encode(['res'=>$res]);
    }

    //修改学生信息
    function stuModify(){
        $validate = Validate::make([
            'sid|学号'  => 'require|max:25|alphaNum',
            'name|姓名' => 'require|max:64',
            'number|学生手机号'=>'require|max:11|mobile',
            'pNumber|父母手机号'=>'require|max:11|mobile',
            'address|家庭地址'=>'require|max:255',
        ]);
        if ($validate->check(Request::post())) {
            $sid = Request::post()['sid'];
            $name = Request::post()['name'];
            $numbse = Request::post()['number'];
            $address = Request::post()['address'];
            $pNumber = Request::post()['pNumber'];
            $len = SyStudent::where("i_sid",$sid)->update(['c_studentname'=>$name,'i_phone_number'=>$numbse,'v_home_address'=>$address,'i_parent_phone'=>$pNumber]);
            if($len){
                echo json_encode(['code'=>true,'meg'=>"修改成功"]);
            }else{
                echo json_encode(['code'=>false,'meg'=>"修改失败"]);
            }
        }else{
            echo json_encode(['code'=>false,'meg'=>$validate->getError()]);
        }
    }
}


