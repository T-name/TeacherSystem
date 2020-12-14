<?php


namespace app\super\controller;


use think\Controller;

class Tools extends Controller
{
    function index(){
        return $this->fetch();
    }
}