<?php


namespace app\index\controller;
use app\common\facade\Account;
use app\common\model\SyClass;
use app\common\model\SyCollect;
use app\common\model\SyCurriculums;
use app\common\model\SyGroup;
use app\common\model\SyStatus;
use app\common\model\SyStudent;
use app\common\model\SyTeacher;
use think\Db;
use think\facade\Session;
use think\Request;
use app\common\validate\Login;
use app\common\controller\Base;
use think\captcha\Captcha;

class Index extends Base
{
//    function test(){
//            for ($i=1;$i<=50;$i++){
//                $stu = new SyStudent();
//                $stu->i_sid = '181260111'.$i;
//                $stu->c_studentname = '武大郎'.$i;
//                $stu->i_classid = '1812610';
//                $stu->i_phone_number = '15879719531';
//                $stu->v_home_address ='江西省';
//                $stu->i_parent_phone = '15879719531';
//                $stu->save();
//            }
//    }

    function index(){
     // dump(SyStatus::get(1));
        //  $this->isLogin(); //防止重复登录
        return $this->view->fetch('common@login',['admin' => '管理员登入']);
    }

    //验证码生成函数
    function  verify(){
        $captcha = new Captcha();
        $captcha->imageH = 45;
        $captcha->imageW = 140;
        $captcha->fontSize = 17;
        $captcha->length = 4;
        return $captcha->entry();
    }

//    登入验证
    function login(Request $request){
        $validatLogin = new Login();
        if(!$validatLogin->check($request->post())){
            $date = ['tips'=>$validatLogin->getError()];
            die(json_encode($date));
        }else{
            $validate = SyTeacher::where('i_headmasterid', $request->post()['user'])
                ->where('v_password', md5($request->post()['password']))
                ->find();
            if($validate){
                $user =  SyTeacher::get($validate['id']);
                $original= $user->getData('i_state');
                $url = $original?'/index.php/admin/admin/home':'/index.php/index/index/home';
                $date =[
                    'state'=>1,
                    'original'=>$original,  //是否为超级管理员
                    'tips' =>'登入成功',
                    'id'=>$validate['id'],
                    'url'=>$url,
                    'name'=>$validate['v_headmastername'],
                    'power'=>$validate['i_state'],
                    'createtime'=>$validate['create_time'],
                    'updatetime'=>$validate['update_time'],
                ];
                $user =['id'=>$validate['i_headmasterid'],'name'=>$validate['v_headmastername'],'original'=>$original];
                Session::set('user',$user);//dump(Session::get('user.name'));  //通过批量设置session值调用session方式。
                die(json_encode($date));
            }else{
                $data = [
                    'state'=>0,
                    'tips'=>'账号或密码错误'
                ];
                die(json_encode($data));
            }
        }
    }


    //若登录成功执行该方法
    function home(){
        $this->vali();
        $this->isIndex();
        return $this->fetch();
    }

    function json(){
        $this->vali();
        $this->isAjax();
        $info['name']=Account::info()['v_headmastername'];
        $info['state'] =Account::info()['i_state'];
        if(Session::has('user.id')){
            $info['isLogin'] = 1;
        }else{
            $info['isLogin'] =0;
        }

        echo json_encode($info);
    }

    function url(){
        $this->vali();
        $this->isAjax();
        if(Session::get('user.original') ==1){
            echo json_encode(['url'=>'/index.php/admin/admin/home']);
        }else{
            echo json_encode(['url'=>'/index.php/index/index/home']);
        }
    }

    //后台面板信息初始化
    function init(){
        $this->vali();
        $this->isAjax();
        $db_data=SyGroup::where('i_teacherid',Session::get("user.id"))->select();
        $studentLength = 0; //总班级人数
        for($i=0;$i<count($db_data);$i++){ //班级人数
           $studentLength = $studentLength + count(SyStudent::where("i_classid",$db_data[$i]["i_classid"])->select());
        }
        if(count(SyStatus::where("c_checkid",Session::get("user.id"))
            ->where('create_time', 'between time', [(time()-604800), time()])
            ->select()) <= 0){
            $Probability = '0';

        }else{
            $Probability = round(count(SyStatus::where("c_checkid",Session::get("user.id"))
                    ->where('c_status','1')
                    ->where('create_time', 'between time', [(time()-604800), time()])
                    ->select()) / count(SyStatus::where("c_checkid",Session::get("user.id"))
                    ->where('create_time', 'between time', [(time()-604800), time()])
                    ->select()) * 100,2); // 正常签到概率
        }

        $work=count(SyCollect::where('v_teacer_id',Session::get('user.id'))
            ->where('end_time', '> time', time())->select());
        echo json_encode(['classLength'=>count($db_data),"studentLength"=>$studentLength,"probability"=>$Probability,"work"=>$work]);
    }

    //统计图
    function chart(){
        $this->vali();
        $this->isAjax();
        $db_data= SyGroup::where('i_teacherid',Session::get("user.id"))->field('i_classid')->select();
        for($i=0;$i<count($db_data);$i++){
            $db_classname = SyClass::where("i_classid",$db_data[$i]['i_classid'])->field("v_classname")->find()["v_classname"];
            @$db_pro = sprintf("%.2f",(Db::query("SELECT COUNT(*) FROM sy_status WHERE c_checkid = '". Session::get("user.id") ."'  AND c_status = '1' AND i_sid IN (SELECT i_sid FROM sy_student WHERE i_classid = '". $db_data[$i]['i_classid'] ."') AND create_time BETWEEN '". (time()-604800) ."' AND " . time())[0]['COUNT(*)'] / Db::query("SELECT COUNT(*) FROM sy_status WHERE c_checkid = '". Session::get("user.id") ."'  AND  i_sid IN (SELECT i_sid FROM sy_student WHERE i_classid = '". $db_data[$i]['i_classid'] ."') AND create_time BETWEEN '". (time()-604800) ."' AND " . time())[0]['COUNT(*)'] * 100));
            $class[$i]["name"]= $db_classname;
            $class[$i]["value"] = $db_pro;

        }
        if($class == null){
            echo json_encode(["code"=>false,'meg'=>"图表无班级记录"]);
        }else{
            echo json_encode(["code"=>true,'res'=>$class]);
        }
    }

    //课表
    function curriculum(){
//        $this->vali();
//        $this->isAjax();
        $db_curriculum= SyCurriculums::where('teacher_id',Session::get('user.id'))->field('curriculums')->find()['curriculums'];
        if($db_curriculum){
            $week[0] = $db_curriculum[6];
            $week[1] = $db_curriculum[0];
            $week[2] = $db_curriculum[1];
            $week[3] = $db_curriculum[2];
            $week[4] = $db_curriculum[3];
            $week[5] = $db_curriculum[4];
            $week[6] = $db_curriculum[5];
            $ano = function ($date) use ($week){
                $data = [];
                for ($i = 0;$i<count($week[$date]);$i++){
                        if(strtotime($week[$date][$i]->start_time) > time()){
                            array_push($data,$week[$date][$i]);
                        }
                }
                if($data){
                    return $data[0];
                }else{
                    return $data;
                }
            };
            if($ano(date('w'))){
                echo json_encode(['code'=>true,'course'=>$ano(date('w'))]);
            }else{
                echo json_encode(['code'=>false,'meg'=>"今日课程已经完成咯"]);
            }
        }else{
            echo json_encode(['code'=>false,'meg'=>'未创建课表']);
        }
    }
}
