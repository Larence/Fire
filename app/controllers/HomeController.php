<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/19 0019
 * Time: 10:07
 */

namespace app\controllers;



use fire\db\Fire;

class HomeController extends AdminController
{

    /**
     * 登录后首页
     */
    public function index(){
        if (Fire::check_login()){
            return redirect('/home/user');
        }
        $this->render();
    }


    public function user(){
        $this->render();
    }

}