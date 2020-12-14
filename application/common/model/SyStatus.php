<?php


namespace app\common\model;


use think\Model;

class SyStatus extends Model
{
    protected $autoWriteTimestamp = true;
    public function getcStatusAttr($value)
    {
        $status = [1=>'正常',2=>'迟到',3=>'旷课',4=>'早退',5=>'请假',6=>'其他'];
        return $status[$value];
    }


}