<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/19 0019
 * Time: 11:38
 * 后台基础控制
 */

namespace app\controllers;


use fire\base\Controller;
use fire\db\Fire;

class AdminController extends Controller
{
    public function __construct($controller, $action)
    {
        if (!Fire::check_login()){
            header('Location: /site/login');
        }
        $this->layout_module = "admin";
        parent::__construct($controller, $action);
    }

}