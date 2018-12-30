<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/19 0019
 * Time: 11:43
 * 前台基础控制
 */

namespace app\controllers;


use fire\base\Controller;

class BaseController extends Controller
{
    public function __construct($controller, $action)
    {
        $this->layout = "main";
        parent::__construct($controller, $action);
    }

}