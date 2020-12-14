<?php


namespace app\index\controller;


use app\common\controller\Base;
use app\common\model\SyClass;
use app\common\model\SyCollect;
use app\common\model\SyCollectWork;
use app\common\model\SyStudent;
use app\common\model\SyTeacher;
use think\facade\Session;
use think\Request;

class Collect extends Base
{
    function initialize()
    {
        $this->isIndex();  //是否为当前模块
    }

    function index(){
        $this->vali();
        return $this->view->fetch();
    }

    //页面生成
    function work(Request $request){
        $this->vali();
        $this->isAjax();
      $data = $request->param();
      if($data['end_time'] !="" && $data['title'] !="" &&  $data['doc'] !=""){
          $collect =new  SyCollect();
          if(strtotime($request->param()['end_time'])>time()){
              $collect->end_time =strtotime($request->param()['end_time']);
          }else{
              echo json_encode(["result"=>"0","tips"=>"截止时间不能小于当前时间"]);
              exit();
          }
          $collect->v_teacer_id = Session::get('user.id');
          $collect->v_title = $data['title'];  //题目
          $collect->v_title_info = $data['info'];  //题目备注
          $collect->v_number = str_shuffle(str_shuffle(md5(time()))); //编号 取时间戳并且打乱2次
          $collect->i_modify = $modify=$data['modify'];  //填写后是否支持修改 默认不允许 1 不允许 2允许
          $collect->i_doc =$data['doc'];  //是否存在文档
          if(!empty($data['classid'])){
              $collect->v_classid =$data['classid'];  //是否存在文档
          }
          $collect->save();
          echo json_encode(["result"=>"1","tips"=>"创建成功","url"=>$request->scheme()."://".$request->host()."/index.php/"."shareID/".$collect->v_number]);
      }else{
          echo json_encode(["result"=>"0","tips"=>"题目或截止时间不可为空"]);
      }
    }

    //渲染我的表单页面
    function Form(){
        $this->vali();
        return $this->fetch();
    }

    //查看我的表单提交人数
    function formData(Request $request){
        $this->vali();
        $shareID = $request->param('shareID');
        $db_data= SyCollectWork::where("v_number",$shareID)->field('v_number,v_name,i_sid,update_time')->select();
        $db_table_info = SyCollect::where('v_number',$shareID)->field('v_title,v_title_info')->find(); //题目
        if($db_table_info == null){
            return $this->error("表单不存在");
        }
        $title=$db_table_info['v_title'];
        $data['code']= true;
        $data['title']=$title; //题目
        $data['note']=$db_table_info['v_title_info']; //题目备注
        if(count($db_data)){
            for($i=0;$i<count($db_data);$i++){
                $data['data'][$i]['number']=$db_data[$i]['v_number'];  //编号
                $data['data'][$i]['name']=$db_data[$i]['v_name'];  //学生姓名
                $data['data'][$i]['sid']=$db_data[$i]['i_sid'];  //学号
                $data['data'][$i]['time']=$db_data[$i]['update_time'];  //最后提交时间
            }
            $this->assign('data',$data);
        }else{
            $this->assign('data',['code'=>false,'title'=>$title,'note'=>$db_table_info['v_title_info']]);
        }
        return $this->fetch('formdata');
    }

    //初始化我的表单页面
    function formInfo(Request $request){
      $this->vali();
      $sq_data =  SyCollect::where("v_teacer_id",Session::get("user.id"))->field("v_number,v_title,v_title_info,i_modify,i_doc,v_classid,end_time")->select();
      $data=null;

      if(!$sq_data ==null){
          for($i =0;$i<count($sq_data);$i++){
              //防止数据库字段直接暴露
              $data[$i]['number']  =$sq_data[$i]['v_number'];  //编号
              $data[$i]['title']  =$sq_data[$i]['v_title'];  //标题
              $data[$i]['info']  =$sq_data[$i]['v_title_info'];  //标题备注
              $data[$i]['modify']  =$sq_data[$i]['i_modify'];  //是否支持修改
              $data[$i]['doc']  =$sq_data[$i]['i_doc'];  //是否支持文档提交
              $data[$i]['doc']  =$sq_data[$i]['i_doc'];  //是否支持文档提交
              $data[$i]['send']  = SyClass::where('i_classid',$sq_data[$i]['v_classid'])->find()['v_classname']?SyClass::where('i_classid',$sq_data[$i]['v_classid'])->find()['v_classname']:"全部";  //谁可以提交
              $data[$i]['endtime']  = date("Y-m-d",$sq_data[$i]['end_time'])."T".date("H:i:s",$sq_data[$i]['end_time']);  //截止日期
              $data[$i]['url']  =$request->scheme()."://".$request->host()."/"."index.php/shareID/".$sq_data[$i]['v_number'];  //提交地址
          }
          echo json_encode($data);
      }
    }

    //修改表单信息
    function modify(Request $request){
        $this->vali();

        if($request->param('number') !=""  &&  $request->param('modify') !="" && $request->param('doc') != "" && $request->param('endtime') !="") {
            if(strtotime($request->param()['endtime'])>time()){
                $lg=   SyCollect::where(['v_number' => $request->param('number'), 'v_teacer_id' => Session::get('user.id')])->update(['v_title_info' => $request->param('info'), "i_modify" => $request->param('modify'), 'i_doc' => $request->param('doc'), 'end_time' => strtotime($request->param('endtime'))]);
                if($lg){
                    echo json_encode(['result'=>1]);
                }else{
                    echo json_encode(['result'=>0,'tips'=>"数据未修改"]);
                }
            }else{
                echo json_encode(['result'=>0,'tips'=>"修改时间不能小于当前时间"]);
            }
        }else{
            echo json_encode(['result'=>0]);
        }
    }
    /**
     * 删除文件夹方法
     */
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

    //表单删除
    function delete(Request $request){
        $this->vali();
        $number=$request->param('number');  //编号

        //删除索引表中数据
        $collect_table_data_delete = SyCollect::where(['v_number'=>$number,"v_teacer_id"=>Session::get('user.id')])->delete();
        //删除删除已填表信息
        SyCollectWork::where(['v_number'=>$number])->delete();

        if($collect_table_data_delete){
            $this->deldir("../uploads/".$number);
            $this->deldir('./static/zip/'.$number.'.zip');
            echo json_encode(['code'=>true,'message'=>"删除成功"]);
        }else{
            //删除失败
            echo json_encode(['code'=>false,"message"=>"删除失败"]);
        }

    }

    //收集信息填写页面渲染 并且初始化
    function collect(Request $request){
        $shareID = $request->param('shareID');  //分享id(编号)
        $sql_data= SyCollect::where('v_number',$shareID)->find();
        if($sql_data == null){
            return $this->error("表单不存在");
        }
        if($sql_data ==null){
            return  $this->error('表单不存在');
        }else{
            $issend = SyClass::where('i_classid',$sql_data['v_classid'])->find()['v_classname']?SyClass::where('i_classid',$sql_data['v_classid'])->find()['v_classname']:"全部";
            $this->assign("data",['shareID'=>$shareID,'title'=>$sql_data['v_title'],"title_info"=>$sql_data['v_title_info'],"modify"=>$sql_data['i_modify'],"issend"=>$issend,'doc'=>$sql_data['i_doc'],'end_time'=>date("Y-m-d H:i:s",$sql_data['end_time'])]);
            return $this->fetch();
        }
    }

    //验证表单是否过期
    protected function valiTime($number){
       $end_time=SyCollect::where('v_number',$number)->field('end_time')->find()['end_time'];
        if($end_time<time()){
            echo json_encode(['code'=>0,'message'=>"提交失败 该表单已经过期了"]);
            exit();
        }
    }

    //验证当前用户是否允许提交 提交验证方法
    protected function isSend($number,$sid){   //number 表单编号  sid 学号
        $classid =  SyCollect::where('v_number',$number)->field('v_classid')->find()['v_classid']; //班级id
        if($classid){
            $db_data = SyStudent::where('i_sid',$sid)->where('i_classid',$classid)->find();
            if($db_data == null){
                echo json_encode(['code'=>0,'message'=>'提交失败 您不能提交该表单']);
                exit();
            }
        }
    }

    /**
     *无文件提交
     */
    protected function docFalse($number,$name,$sid,$content,$note){
        $this->valiTime($number);  //验证表单是否过期
        //开始数据验证
        $validate = new \app\common\validate\CollectText();  //数据验证类
        //需要验证得数据
        $vali_data['number']=$number;
        $vali_data['name']=$name;
        $vali_data['sid']=$sid;
        $vali_data['content']=$content;
        $vali_data['note']=$note;

        //验证开始
        if($validate->check($vali_data)){
            //数据验证成功
            $work = new  SyCollectWork();  //预先实例化作业表
            //是否重复提交
            if(SyCollectWork::where('v_number',$number)->where('i_sid',$sid)->find()){
                //是重复提交
                if(SyCollect::where('v_number',$number)->where('i_modify',2)->find()){ //是否允许重复提交
                    //是重复提交 并且允许重复提交
                    $db_content['code']=0;
                    $db_content['content']=$content;
                    $data =['v_name'=>$name,'v_content'=>json_encode($db_content),'v_note'=>$note];
                    if($work->save($data,['i_sid' =>$sid])){
                        echo json_encode(['code'=>1,'message'=>'更新提交成功']);
                    }
                }else{
                    //是重复提交 但是不允许重复提交
                    echo json_encode(['code'=>0,'message'=>"提交失败 该表单不允许重复提交"]);
                }
            }else{
                //不是重复提交则直接插入即可
                $db_content['code']=0;
                $db_content['content']=$content;
                $data =['v_number'=>$number,'v_name'=>$name,'i_sid'=>$sid,'v_content'=>json_encode($db_content),'v_teacher_id'=>Session::get('user.id'),'v_note'=>$note];
                $result=$work->save($data);  //插入数据
                /**
                 * 是否成功判断
                 */
                if($result){
                    echo json_encode(['code'=>1,'message'=>'提交成功']);
                }else{
                    echo json_encode(['code'=>0,'message'=>'提交失败 请重新提交']);
                }
            }
        }else{
            //数据验证失败返回
            echo json_encode(['code'=>0,'message'=>$validate->getError()]);
        }
    }

    /**
     *有文件提交
     * 测试环境php已设置上传最大文件大小 20M
     * 表单提交信息最大 20M
     * 单个PHP页面最大运行60秒
     * 单个PHP页面接收信息最大60秒
     *超过上述大小报错
     */
    protected function docTrue($number,$name,$sid,$file,$note){
        $this->valiTime($number);  //验证表单是否过期
        $validate = new \app\common\validate\CollectFile();  //数据验证类
        //需要验证得数据
        $vali_data['number']=$number;
        $vali_data['name']=$name;
        $vali_data['sid']=$sid;
        //开始验证
        if($validate->check($vali_data)){
            //数据验证成功
            $work = new  SyCollectWork();  //预先实例化作业表
            if(SyCollectWork::where('v_number',$number)->where('i_sid',$sid)->find()){ //是否重复提交
                //是重复提交
                if(SyCollect::where('v_number',$number)->where('i_modify',2)->find()){ //是否允许重复提交
                    //是重复提交并且允许重复提交
                    $info = $file->validate(['size'=>8388608,'ext'=>'7z,zip,rar'])->rule(function () use ($sid){ return $sid;})->move( '../uploads/'.$number);  //限制最大提交8M
                   // $info = $file->rule(function () use ($sid){ return $sid;})->move( '../uploads/'.$number);
                    if($info){
                        $fileName= $info->getSaveName();
                        $db_content['code']=1;
                        $db_content['content']=$number."/".$fileName;  //数据库存入编号+学号
                        /**
                         * 路径路径命名规范  在uploads目录下文件夹名字以表单编号命名，文件以学号命名
                         */
                        $data =['v_name'=>$name,'v_content'=>json_encode($db_content),'v_note'=>$note];
                        $result=$work->save($data,['i_sid' =>$sid]);  //更新数据
                        /**
                         * 是否成功判断
                         */
                        if($result){
                            echo json_encode(['code'=>1,'message'=>'更新提交成功']);
                        }else{
                            echo json_encode(['code'=>0,'message'=>'更新提交失败 请重新提交']);
                        }
                    }else{
                        echo json_encode(['code'=>0,'message'=>$file->getError()]); //文件不符合规范
                    }
                }else{
                    //是重复提交 但是不允许重复提交
                    echo json_encode(['code'=>0,'message'=>"提交失败 该表单不允许重复提交"]);
                }
            }else{
                //不是重复提交则直接插入即可
                $info = $file->validate(['size'=>8388608,'ext'=>'7z,zip,rar'])->rule(function () use ($sid){ return $sid;})->move( '../uploads/'.$number);  //限制最大提交8M
                $fileName= $info->getSaveName();
                $db_content['code']=1;
                $db_content['content']=$number."/".$fileName;  //数据库存入编号+学号
                /**
                 * 路径路径命名规范  在uploads目录下文件夹名字以表单编号命名，文件以学号命名
                 */
                $data =['v_number'=>$number,'v_name'=>$name,'i_sid'=>$sid,'v_content'=>json_encode($db_content),'v_teacher_id'=>Session::get('user.id'),'v_note'=>$note];
                $result=$work->save($data);  //插入数据
                /**
                 * 是否成功判断
                 */
                if($result){
                    echo json_encode(['code'=>1,'message'=>'提交成功']);
                }else{
                    echo json_encode(['code'=>0,'message'=>'提交失败 请重新提交']);
                }
            }
        }else{
            //数据验证失败
            echo json_encode(['code'=>0,'message'=>$validate->getError()]);
        }
    }

    /**
     * 处理提交过来的数据
     */
    function data(Request $request){
        $this->isAjax();
        //公共数据部分
        $number =$request->param()['number']; //编号
        $name =$request->param()['name']; //名字
        $sid =$request->param()['sid']; //学号
        $this->isSend($number,$sid);  //调用是否允许提交验证方法

        $note =$request->param()['note']; //备注
        $is_doc= $request->param('doc');  //传输过来是否有文件
        $db_is_doc= SyCollect::where('v_number',$number)->find()['i_doc'];  //是否允许传输文件
        if($db_is_doc == $is_doc ||$db_is_doc==3 ){
            switch ($is_doc){
                case 1:
                    $content =$request->param()['content']; //文本内容
                    $this->docFalse($number,$name,$sid,$content,$note);break;
                case 2:
                    $file = request()->file('file');  //取提交文件
                  //  $this->valifile($file);
                    $this->docTrue($number,$name,$sid,$file,$note);break;
            }
        }else{
            echo json_encode(['code'=>0,'message'=>"该表单不允许提交文件"]);
        }
    }

    //查看表单详细提交内容
    function content(Request $request){
        $this->vali(); //验证登录
        $shareID=$request->param('shareID');
        $studentID=$request->param('studentID');
        $db_data= SyCollectWork::where(['v_number'=>$shareID,'i_sid'=>$studentID])->field('v_name,i_sid,v_note,v_content,update_time')->find();
        if($db_data == null){
            return $this->error('表单不存在');
        }
        $data['title']=SyCollect::where('v_number',$shareID)->field('v_title')->find()['v_title'];
        $data['name']=$db_data['v_name'];
        $data['sid']=$db_data['i_sid'];
        $data['note']=$db_data['v_note'];
        $json_date =json_decode($db_data['v_content'],true);
        $data['code']=$json_date['code'];
        $data['content']=$json_date['content'];
        $data['time']=$db_data['update_time'];
        $this->assign('data',$data);
        return $this->fetch();
    }

    //文件生成
    function file(Request $request){
        $this->vali(); //验证登录
        $this->isAjax(); //是否ajax访问
        $sid =$request->param();
        $zip =new \ZipArchive();  //zip操作对象
        for($i=0;$i<count($sid['sid']);$i++){
            $work_info = SyCollectWork::where(['i_sid'=>$sid['sid'][$i]])->find();
            $open=$zip->open('../uploads/'.$work_info['v_number'].'/'.$work_info['v_number'].'.zip',\ZIPARCHIVE::CREATE);  //打开一个zip文件
            if($open){  //压缩文件是否打开
                $title= SyCollect::where(['v_number'=>$work_info['v_number'],'v_teacer_id'=>Session::get('user.id')])->field('v_title')->find()['v_title'];
                if(json_decode($work_info['v_content'],true)['code']){
                    /**
                     * 文本文件下载
                     */
                    $zip->addFile('../uploads/'.json_decode($work_info['v_content'],true)['content']);
                }else{
                    /**
                     * 内容文件下载操作
                     */
                    //判断文件夹是否存在
                    if(file_exists('../uploads/'.$work_info['v_number'])){
                        $file= touch('../uploads/'.$work_info['v_number'].'/'.$work_info['i_sid'].'.html');  //指定目录创建一个文件，用来保存学生提交过来的文本内容
                    }else{
                        mkdir('../uploads/'.$work_info['v_number']);  //如果文件不存在就创建
                        $file= touch('../uploads/'.$work_info['v_number'].'/'.$work_info['i_sid'].'.html');  //指定目录创建一个文件，用来保存学生提交过来的文本内容
                    }
                    if($file){  //判断文件是否被创建成功
                        $str1=file_get_contents('./static/template/temp.html');  //获取模板文件内容
                        if($str1){  //判断我们文件内容是否被或获取成功
                            /**
                             * 文件内容渲染操作
                             */
                            $open=fopen('../uploads/'.$work_info['v_number'].'/'.$work_info['i_sid'].'.html','w');
                            $str2='<body class="mdui-theme-primary-indigo mdui-theme-accent-red">
                        <div class="mdui-container-fluid mdui-m-y-2 mdui-card" style="max-width: 1040px">
                            <div><b><p class="title">'.$title.'</p></b></div>
                            <div style="color: #607d8b;"><span>'.$work_info['v_name'].'</span>&nbsp;/<span> '.$work_info['i_sid'].'</span><span class="mdui-float-right">'.$work_info['update_time'].'</span></div>
                        <div class= "mdui-m-t-2 mdui-m-b-1"></div>
                        <div class="content mdui-typo">
                        '.json_decode($work_info['v_content'],true)['content'].'
                        </div>
                        </div>                      
                        </body>
                        </html>';
                            fwrite($open,$str1.$str2);
                            fclose($open);  //记得关闭文件
                        }else{
                            die(json_encode(['code'=>false,',meg'=>'模板文件内容获取失败 请重试']));
                        }
                    }else{
                        die(json_encode(['code'=>false,'meg'=>$work_info['number'].'文件创建失败 请重试']));
                    }
                }
            }else{
                die(json_encode(['code'=>false,'meg'=>'压缩文件打开失败 请重试']));
            }
            /**
             * 打包zip文件操作
             */
                $zip->addFile('../uploads/'.$work_info['v_number'].'/'.$work_info['i_sid'].'.html');
                $zip->close();//记得关闭zip文件
        }

        rename('../uploads/'.$work_info['v_number'].'/'.$work_info['v_number'].'.zip','./static/zip/'.$work_info['v_number'].'.zip');  //将打包好的文件剪切到指定目录。

        $number=$work_info['v_number'];  //需要下载的文件编号
        $this->download($number);  //下载方法

    }

    //下载方法
    protected function download($number){
        $this->vali(); //验证登录
        $file= './static/zip/'.$number.'.zip';  //需要下载的文件
        if($file !="" && file_exists($file)){
            echo json_encode(['code'=>'file','meg'=> '/static/zip/'.$number.'.zip']);
        }else{
            echo json_encode(['code'=>true,'meg'=>'文件不存在 请重试']);
        }
    }
}