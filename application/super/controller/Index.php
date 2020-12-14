<?php


namespace app\super\controller;


use app\common\model\SyClass;
use app\common\model\SyGroup;
use app\common\model\SyTeacher;
use think\Controller;
use think\Exception;
use think\facade\Request;
use think\facade\Validate;
use think\facade\Session;

class Index extends Controller
{
    function initialize()
    {
        if(!Session::has('token')){
            return $this->error('请先登录','/index.php/super/login/login');
        }
    }

    //页面渲染
    function index(){
        return $this->fetch();
    }

    //配置班主任表
    function importH(){
        try {
            $success= [];  //成功记录
            $error = [];   //失败记录
            $data = json_decode(Request::post()['data'],true);
            if($data == null){
                echo  json_encode(['code'=>false,'meg'=>"模板文件为空"]);
                return;
            }
            //数据验证规则
            $validate = Validate::make([
                'tid|班主任ID'  => 'require|min:6|number|max:25',
                'name|姓名' => 'require|max:64',
                'password|密码' => 'require|max:32|min:6|alphaNum',
                'state|权限' => 'in:0,1|require',
            ]);

            for($i=0;$i<count($data);$i++){
                //需要验证的数据
                $v_data = [
                    'tid'  => $data[$i]['班主任id'],
                    'name' => $data[$i]['姓名'],
                    'password' => $data[$i]['密码'],
                    'state' => $data[$i]['权限'],
                ];

                if(!$validate->check($v_data)) {
                    array_push($error,$v_data['tid'].$validate->getError());
                    continue;
                }

                if(SyTeacher::where('i_headmasterid',$data[$i]['班主任id'])->find()){
                    array_push($error,"帐号ID".$data[$i]['班主任id'] ."已存在");
                }else{
                    $tc = new SyTeacher();
                    $len = $tc->save([
                        'i_headmasterid'=>$data[$i]['班主任id'],
                        'v_headmastername' => $data[$i]['姓名'],
                        'v_password' => md5(md5($data[$i]['密码'])),
                        'i_state' => $data[$i]['权限']
                    ]);
                    if($len){
                        array_push( $success,"帐号ID".$data[$i]['班主任id']."添加成功");
                    }
                }
            }
            $res['code'] = true;
            $res['success'] = $success;
            $res['error'] = $error;
            echo  json_encode($res);
        }catch (Exception $e){
            echo  json_encode(['code'=>false,'meg'=>"模板文件错误 请重新下载再导入信息"]);
        }
    }

    //班级配置表
    function importC(){
        try {
            $success= [];  //成功记录
            $error = [];   //失败记录
            $data = json_decode(Request::post()['data'],true);
            if($data == null){
                echo  json_encode(['code'=>false,'meg'=>"模板文件为空"]);
                return;
            }
            //数据验证规则
            $validate = Validate::make([
                'classid|班级ID'  => 'require|number|min:5|max:20',
                'classname|班级名字' => 'require|max:128|min:2',
                'headmasterid|班主任ID' => 'require|min:6|max:24|number',
            ]);

            for ($i = 0;$i<count($data);$i++){
                $v_data = [
                    'classid'  => $data[$i]['班级ID'],
                    'classname' => $data[$i]['班级名字'],
                    'headmasterid' => $data[$i]['班主任ID'],
                ];
                if(!$validate->check($v_data)) {
                    array_push($error,$v_data['classid'].$validate->getError());
                    continue;
                }

                if(SyClass::where('i_classid',$data[$i]['班级ID'])->find() || SyClass::where('v_classname',$data[$i]['班级名字'])->find()){
                    array_push($error,"班级ID".$data[$i]['班级ID'] ."已存在");
                }else{
                    $tc = new SyClass();
                    $len = $tc->save([
                        'i_classid'=>$data[$i]['班级ID'],
                        'v_classname' => $data[$i]['班级名字'],
                        'i_headmasterid' => $data[$i]['班主任ID'],
                    ]);
                    if($len){
                        array_push( $success,"班级ID".$data[$i]['班级ID']."添加成功");
                    }
                }
            }
            $res['code'] = true;
            $res['success'] = $success;
            $res['error'] = $error;
            echo  json_encode($res);
        }catch (Exception $e){
            echo  json_encode(['code'=>false,'meg'=>"模板文件错误 请重新下载再导入信息"]);
        }
    }

    //课任教师配置表
    function importT(){
        try {
            $success= [];  //成功记录
            $error = [];   //失败记录
            $data = json_decode(Request::post()['data'],true);
            if($data == null){
                echo  json_encode(['code'=>false,'meg'=>"模板文件为空"]);
                return;
            }
            //数据验证规则
            $validate = Validate::make([
                'classid|班级ID'  => 'require|min:5|number|max:64',
                'teacherid|任课教师ID' => 'require|min:6|number|max:64',
            ]);

            for ($i = 0;$i<count($data);$i++){
                $v_data = [
                    'classid'  => $data[$i]['班级ID'],
                    'teacherid' => $data[$i]['任课教师ID'],
                ];
                if(!$validate->check($v_data)) {
                    array_push($error,$v_data['classid'].$validate->getError());
                    continue;
                }

                if(SyGroup::where('i_classid',$data[$i]['班级ID'])->where('i_teacherid',$data[$i]['任课教师ID'])->find()){
                    array_push($error,"班级ID为".$data[$i]['班级ID'] ."与任课教师ID为". $data[$i]['任课教师ID'] ."的记录已存在");
                }else{
                    $tc = new SyGroup();
                    $len = $tc->save([
                        'i_classid'=>$data[$i]['班级ID'],
                        'i_teacherid' => $data[$i]['任课教师ID'],
                    ]);
                    if($len){
                        array_push( $success,"班级ID为".$data[$i]['班级ID'] ."与任课教师ID为". $data[$i]['任课教师ID'] ."的记录已添加成功");
                    }
                }
            }
            $res['code'] = true;
            $res['success'] = $success;
            $res['error'] = $error;
            echo  json_encode($res);
        }catch (Exception $e){
            echo  json_encode(['code'=>false,'meg'=>"模板文件错误 请重新下载再导入信息"]);
        }
    }

    /**
     *各个表数据
     */
    function dataH(\think\Request $request){
        $dataH = [];
        $page = $request->get('page');
        $length = $request->get('length');

       // $db_data_h = SyTeacher::where(1,'or',-1)->field("i_headmasterid,v_headmastername,i_state,create_time,update_time")->limit($page,$length)->select();
        $db_data_h = SyTeacher::where(1,'or',-1)->field("i_headmasterid,v_headmastername,i_state,create_time,update_time")->select();

        //教师表  $dataH
        foreach ($db_data_h as $key =>$value) {
            $dataH[$key]['hid']= $db_data_h[$key]['i_headmasterid'];
            $dataH[$key]['hname']= $db_data_h[$key]['v_headmastername'];
            $dataH[$key]['state']= $db_data_h[$key]['i_state'];
            $dataH[$key]['create']= $db_data_h[$key]['create_time'];
            $dataH[$key]['update']= $db_data_h[$key]['update_time'];
        }
        if($dataH != null){
            echo json_encode(['code'=>true,"res"=>$dataH]);
        }else{
            echo json_encode(['code'=>false,"meg"=>'无帐户']);
        }
    }

    function dataC(\think\Request $request){
        $dataC = [];
        $page = $request->get('page');
        $length = $request->get('length');

       // $db_data_c = SyClass::where(1,'or',-1)->field('v_classname,i_classid,i_headmasterid,i_headmasterid,create_time')->limit($page,$length)->select();
        $db_data_c = SyClass::where(1,'or',-1)->field('v_classname,i_classid,i_headmasterid,i_headmasterid,create_time')->select();
        //班级表 $dataC
        foreach ($db_data_c as $key =>$value) {
            $dataC[$key]['classname']= $db_data_c[$key]['v_classname'];
            $dataC[$key]['classid']= $db_data_c[$key]['i_classid'];
            $dataC[$key]['hname']= SyTeacher::where('i_headmasterid',$db_data_c[$key]['i_headmasterid'])->field("v_headmastername")->find()['v_headmastername'];
            $dataC[$key]['hid']= $db_data_c[$key]['i_headmasterid'];
            $dataC[$key]['create']= $db_data_c[$key]['create_time'];
        }
        if($dataC !=null){
            echo json_encode(['code'=>true,"res"=>$dataC]);
        }else{
            echo json_encode(['code'=>false,"meg"=>"无班级"]);
        }
    }

    function dataT(\think\Request $request){
        $dataT = [];
        $page = $request->get('page');
        $length = $request->get('length');

       // $db_data_t =SyGroup::where(1,'or',-1)->field('i_classid,i_teacherid,create_time')->limit($page,$length)->select();
        $db_data_t =SyGroup::where(1,'or',-1)->field('i_classid,i_teacherid,create_time')->select();
        //课任老师表 $dataT
        foreach ($db_data_t as $key =>$value) {
            $dataT[$key]["classname"] = SyClass::where("i_classid",$db_data_t[$key]['i_classid'])->field("v_classname")->find()["v_classname"];
            $dataT[$key]["classid"] = $db_data_t[$key]['i_classid'];
            $dataT[$key]["tname"] = SyTeacher::where("i_headmasterid",$db_data_t[$key]['i_teacherid'])->field("v_headmastername")->find()["v_headmastername"];
            $dataT[$key]["tid"] = $db_data_t[$key]['i_teacherid'];
            $dataT[$key]['create'] = $db_data_t[$key]['create_time'];
        }
        if($dataT !=null){
            echo json_encode(['code'=>true,"res"=>$dataT]);
        }else{
            echo json_encode(['code'=>false,"meg"=>"无任课老师"]);
        }
    }

    //删除帐号
    function deleteH(\think\Request $request){
        $hid = $request->post('hid');
        $booln = SyTeacher::where('i_headmasterid',$hid)->delete();
        if($booln){
            echo json_encode(['code'=>true,'meg'=>'删除成功']);
        }else{
            echo json_encode(['code'=>false,'meg'=>'删除失败']);
        }
    }

    //修改密码
    function modify(\think\Request $request){
        $hid = $request->post('hid');
        $password = $request->post('password');
        //验证数据
        $validate = Validate::make([
            'hid|帐号'  => 'require|max:24|number',
            'password|密码' => 'require|max:32|min:6|alphaNum'
        ]);

        if (!$validate->check($request->post())) {
             echo json_encode(['code'=>false,'meg'=>$validate->getError()]);
             return;
        }

        $booln = SyTeacher::where('i_headmasterid',$hid)->update(['v_password'=>md5(md5($password))]);
        if($booln){
            echo json_encode(['code'=>true,'meg'=>'修改成功']);
        }else{
            echo json_encode(['code'=>false,'meg'=>'修改失败 密码不能与当前密码一直']);
        }
    }

    //删除班级
    function deleteC(\think\Request $request){
        $validate = Validate::make([
            'hid|帐号'  => 'require|max:24|min:6|number',
            'classid|班级' => 'require|max:32|min:5|number'
        ]);

        if (!$validate->check($request->post())) {
            echo json_encode(['code'=>false,'meg'=>$validate->getError()]);
            return;
        }
        $boolen = SyClass::where(['i_classid'=>$request->post('classid'),'i_headmasterid'=>$request->post('hid')])->delete();
        if($boolen){
            echo json_encode(['code'=>true,'meg'=>"删除成功"]);
        }else{
            echo json_encode(['code'=>false,'meg'=>"删除失败"]);
        }
    }

    //删除课任教师
    function deleteT(\think\Request $request){
        $validate = Validate::make([
            'tid|帐号'  => 'require|max:24|min:6|number',
            'classid|班级' => 'require|max:32|min:5|number'
        ]);
        if (!$validate->check($request->post())) {
            echo json_encode(['code'=>false,'meg'=>$validate->getError()]);
            return;
        }
        $boolen = SyGroup::where(['i_classid'=>$request->post('classid'),'i_teacherid'=>$request->post('tid')])->delete();
        if($boolen){
            echo json_encode(['code'=>true,'meg'=>"删除成功"]);
        }else{
            echo json_encode(['code'=>false,'meg'=>"删除失败"]);
        }
    }
}