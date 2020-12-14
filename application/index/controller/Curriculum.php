<?php


namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\SyClass;
use app\common\model\SyCurriculums;
use think\facade\Request;
use think\facade\Session;
use think\Validate;

class Curriculum extends Base
{
    function index(){
        $this->vali();
        return $this->fetch();
    }
    
    function create(){
        $this->vali();
        $this->isAjax();
        $data = json_decode(Request::param()['data'],true);
        if(empty(array_filter($data))){
            echo json_encode(['code'=>false,'meg'=>"创建失败 提交参数不能为空"]);
            return;
        }
        $validate = Validate::make([
            'date|日期'  => ['in:1,2,3,4,5,6,7'],
            'course|课程' => ['require','max:128'],
            'class|班级' => ['require','max:128|number'],
            'classroom|教室' => ['require','max:128'],
            'start_time|上课时间' => ['require','max:128|date'],
            'end_time|下课时间' => ['require','max:128|date'],
        ]);
        //循环验证
        for($i=0;$i<count($data);$i++){
            for($j=0;$j<count($data[$i]);$j++){
                if (!$validate->check($data[$i][$j])) {
                    echo json_encode(['code'=>false,'meg'=>'序号为'.$i."/".$j."的".$validate->getError()."请重新规范填写"]);
                    return;
                }
                if(strtotime($data[$i][$j]["end_time"]) < strtotime($data[$i][$j]["start_time"]) ){
                    echo json_encode(['code'=>false,'meg'=>"上课时间不能大于下课时间 请检查数据"]);
                    return;
                }
                if(strtotime($data[$i][$j]["end_time"]) == strtotime($data[$i][$j]["start_time"]) ){
                    echo json_encode(['code'=>false,'meg'=>"上课时间不能等于下课时间 请检查数据"]);
                    return;
                }
//                if(count($data[$i]) >= 2){
//                    if(strtotime($data[$i][$j]["end_time"]) > strtotime($data[$i][$j+1]["start_time"])){
//                        echo json_encode(['code'=>false,'meg'=>"上节课下课时间不能大于下节课上课时间"]);
//                        return;
//                    }
//                }
                $data[$i][$j]['class'] = SyClass::where("i_classid",$data[$i][$j]['class'])->field('v_classname')->find()['v_classname'];
            }
        }

        //判断是否为首次添加
        $curriculum = SyCurriculums::where('teacher_id',Session::get("user.id"))->find();
        if($curriculum){
            $curriculum->curriculums = $data;  //存json
            $bool = $curriculum->save();
        }else{
            $curriculum = new SyCurriculums();
            $curriculum->teacher_id = Session::get("user.id");
            $curriculum->curriculums = $data;  //存json
            $bool = $curriculum->save();
        }
        if($bool){
            echo json_encode(['code'=>true,'meg'=>"全部更新成功"]);
        }else{
            echo json_encode(['code'=>false,'meg'=>"更新失败"]);
        }
    }

    function init(){
        $this->vali();
        $this->isAjax();
        $curriculum = SyCurriculums::where('teacher_id',Session::get('user.id'))->field("curriculums")->find();
        if($curriculum != null){
            echo  json_encode(['code'=>true,'res'=>$curriculum]);
        }else{
            echo  json_encode(['code'=>false,'meg'=>"未创建课表"]);
        }
    }
}