<?php


namespace app\admin\controller;

use app\common\controller\Base;
use app\common\model\SyClass;
use app\common\model\SyStudent;
use think\Exception;
use think\facade\Request;
use think\facade\Session;


class Input extends Base
{
    function  index (){
        $this->vali();
        if(count(SyClass::where('i_headmasterid',Session::get('user.id'))->select())){
            return $this->fetch();
        }else{
            return  $this->error('当前帐号暂无数据');
        }
    }

    //单个数据导入操作
    function input(){
        $this->vali();
        $validate = new \app\common\validate\Input();
        if (!$validate->check(Request::param())) {
            $this->vali();
            echo json_encode(['tips'=>$validate->getError()]);
        }else{
            $repeat = SyStudent::where('i_sid',Request::param()['studentid'])->find();
            if(SyClass::where(['i_classid'=>Request::param()['class'],'i_headmasterid'=>Session::get('user.id')])->find()){
                if($repeat == null){
                    $student = new SyStudent();
                    $student->i_sid = Request::param()['studentid'];
                    $student->c_studentname = Request::param()['name'];
                    $student->i_classid = Request::param()['class'];
                    $student->i_phone_number = Request::param()['phone'];
                    $student->i_parent_phone = Request::param()['p_phone'];
                    $student->v_home_address = Request::param()['address'];
                    $ifbool = $student->save();
                    if($ifbool){
                        echo json_encode(['tips'=>'添加成功']);
                    }else{
                        echo json_encode(['tips'=>'添加失败']);
                    }
                }else{
                    echo json_encode(['tips' =>'该学号已存在']);
                }
            }else{
                echo json_encode(['tips' =>'班级ID为'.Request::param()['class'].'您无权限添加']);
            }
        }
    }

    //清空文件夹函数和清空文件夹后删除空文件夹函数的处理
    protected function deldir($path){
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $arrfile = scandir($path);
            foreach($arrfile as $val){
                //排除目录中的.和..
                if($val !="." && $val !=".."){
                    if(is_file($path.'/'.$val)){  //如果该文件存在
                        @unlink($path.'/'.$val);  //删除文件
                    }else{
                        @rmdir($path);  //删除空文件夹
                    }
                }
                @rmdir($path);  //删除空文件夹
            }
        }
    }

    //文件批量数据导入
    function file(){
        $this->vali();
       $file = request()->file('file');
       if($file){
           $info = $file->validate(['size'=>8388608,'ext'=>'xls,xlsx'])->move( '../uploads');  //限制文件大小并且限制后缀
           if($info){
               $errortips =[];  //错误信息
               $data = []; //筛选后可用数据条数
               $filevalidata = new \app\common\validate\File();  //文件信息验证
               $file = '../uploads/'.$info->getSaveName();  //文件接收
               $phpexcel = new \PHPExcel();  //导入excel类
               $obj = \PHPExcel_IOFactory::load($file);  //载入表格
               $exceldata=$obj->getSheet(0)->toArray();//  选中第一张sheet，并且把数据组化

               for($i=1;$i<count($exceldata);$i++){
                   $temp =[
                       'i_classid'=>$exceldata[$i][0],
                       'c_studentname'=>$exceldata[$i][1],
                       'i_sid'=>(string)$exceldata[$i][2],
                       'i_phone_number'=>$exceldata[$i][3],
                       'v_home_address'=>$exceldata[$i][4],
                       'i_parent_phone'=>$exceldata[$i][5],
                   ];

                   //同类型账号防止意外添加学生
                   if(!SyClass::where(['i_classid'=>$temp['i_classid'],'i_headmasterid'=>Session::get('user.id')])->find()){
                       $errortips[] = '班级为ID为'.$temp['i_classid'].'的学生您无权添加<br/>';
                       continue;
                   }


                   //文件数据验证
                   if (!$filevalidata->check($temp)) {
                       $errortips[]= $temp['c_studentname']?$temp['c_studentname'].$filevalidata->getError().'<br>':'某处'.$filevalidata->getError().'请检查数据表<br>';
                       continue;
                   }

                   //防止重复添加
                   if(SyStudent::where('i_sid',$temp['i_sid'])->find()){
                       $errortips[] = $temp['i_sid'].'学号已经存在 请检查是否重复添加';
                       continue;  //跳出该次循环
                   }
                       $data[$i-1] = $temp; //筛选可用数据
               }
               //向数据库添加数据
               $systudent = new SyStudent();
               $res =$systudent->saveAll($data);
               $result['count'] = count($exceldata) -1;//数据总条数
               $result['success']=count($res);  //添加成功数据
               $result['error'] =$errortips;  //错误信息
               echo json_encode(['code'=>true,'result'=>$result]);  //返回json
           }else{
               echo json_encode(['code'=>false,'result'=>$file->getError()]);// 上传失败获取错误信息
           }
       }
    }

    function deleteTemp(){
        $this->vali();
        $this->isAjax();
        $this->deldir("../uploads/". date("Ymd"));
    }

}