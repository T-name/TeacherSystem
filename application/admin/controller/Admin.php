<?php


namespace app\admin\controller;


use app\common\controller\Base;
use app\common\model\SyClass;
use think\Db;
use think\facade\Session;
use think\Request;


class Admin extends Base
{
    function home(Request $request){
        $this->vali();
        return $this->fetch();
    }

    //数据初始化
    function data(){
        $this->vali();
        $this->isAjax();
        $sql_data = SyClass::where('i_headmasterid',Session::get('user.id'))->select();   // 取班级数
        if(count($sql_data)){
            for ($i = 0;$i<count($sql_data);$i++){
                $classdata[$i]['classid'] = $sql_data[$i]['i_classid'];  //班级id
                $classdata[$i]['classname'] = $sql_data[$i]['v_classname'];  //班级id
            }
            $studentlength= Db::query('SELECT COUNT(*) FROM `sy_student`  WHERE i_classid IN (SELECT i_classid FROM sy_class WHERE i_headmasterid = '.Session::get("user.id").')')[0]['COUNT(*)'];  //查询当前帐号班级总人数  包含软删除人数

            if($studentlength > 0){
                $total = Db::query('SELECT COUNT(*) FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '.Session::get("user.id").')) as student  on student.i_sid = sy_status.i_sid WHERE sy_status.update_time BETWEEN '. (time() - 604800) .' AND ' . (time()))[0]['COUNT(*)']; //7天内总签到数
                $normal = Db::query('SELECT COUNT(*) FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '.Session::get("user.id").')) as student  on student.i_sid = sy_status.i_sid WHERE c_status = "1"  AND sy_status.update_time BETWEEN '. (time() - 604800) .' AND ' . (time()))[0]['COUNT(*)']; //7天内正常签到率

                if($total > 0 && $normal > 0){
                    $probability =  $normal / $total * 100;  //7天内正常签到率

                    $classid =SyClass::where('i_headmasterid',Session::get('user.id'))->field('i_classid,v_classname')->select();
                    for ($i=0;$i< count($classid);$i++){
                        $class_total=  Db::query('SELECT COUNT(*) FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '.Session::get("user.id").')) as student  on student.i_sid = sy_status.i_sid WHERE student.i_classid = '. $classid[$i]['i_classid'] .' AND sy_status.update_time BETWEEN '. (time() - 604800) .' AND ' . (time()))[0]['COUNT(*)'];  //取指定班级7天内总签到记录数
                        if($class_total > 0){
                            $class_total_status=  Db::query('SELECT COUNT(*) FROM sy_status INNER JOIN (SELECT * FROM sy_student WHERE i_classid in (SELECT i_classid FROM sy_class WHERE  i_headmasterid = '.Session::get("user.id").')) as student  on student.i_sid = sy_status.i_sid WHERE student.i_classid = '. $classid[$i]['i_classid'] .' AND c_status = "1" AND sy_status.update_time BETWEEN '. (time() - 604800) .' AND '. time())[0]['COUNT(*)']; //取指定班级指定签到状态记录数
                            $classstatus[$i]['probability'] = round($class_total_status / $class_total * 100,2);
                            $classstatus[$i]['classname'] = $classid[$i]['v_classname'];
                        }else{
                            $classstatus[$i]['probability'] = "0";
                            $classstatus[$i]['classname'] = $classid[$i]['v_classname'];
                        }
                    }
                    echo  json_encode(["code"=>1,"classdata"=>$classdata,'studentlength'=>$studentlength,'Probability'=>round($probability,2),'classstatus'=>$classstatus]);
                }else{
                    echo  json_encode(["code"=>2,"classdata"=>$classdata,'studentlength'=>$studentlength,"result"=>"班级暂无签到数据"]);
                }
            }else{
                echo  json_encode(["code"=>3,"classdata"=>$classdata,"result"=>"班级暂未分配学生"]);
            }
        }else{
            echo  json_encode(["code"=>4,"result"=>"该帐号未分配数据"]);
        }
    }

    //统计图
    function chart(){
//     // dump(Db::query("SELECT * FROM sy_status WHERE i_sid IN (SELECT i_sid FROM sy_student WHERE i_classid IN (SELECT i_classid FROM sy_class  WHERE i_headmasterid =".Session::get('user.id')."))"));
//      dump();

        $db_class = SyClass::where('i_headmasterid',Session::get('user.id'))->field('i_classid,v_classname')->select();
        for($i=0;$i<count($db_class);$i++){
            $class[$i]["name"]= $db_class[$i]['v_classname'];
            @$pro = sprintf("%.2f",(Db::query("SELECT COUNT(*) FROM sy_status WHERE i_sid IN (SELECT i_sid FROM sy_student WHERE i_classid =".$db_class[$i]['i_classid'].") AND c_status = '1' AND create_time BETWEEN  '".(time()-604800)."' AND '".time()."'")[0]['COUNT(*)']/Db::query("SELECT COUNT(*) FROM sy_status WHERE i_sid IN (SELECT i_sid FROM sy_student WHERE i_classid =".$db_class[$i]['i_classid'].") AND create_time BETWEEN  '".(time()-604800)."' AND '".time()."'")[0]['COUNT(*)']*100));
            $class[$i]["value"] = $pro;
        }
        if($class == null){
            echo json_encode(["code"=>false,'meg'=>"图表无班级记录"]);
        }else{
            echo json_encode(["code"=>true,'res'=>$class]);
        }
    }
}