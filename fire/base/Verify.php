<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/19 0019
 * Time: 15:54
 * 登录 注册验证
 */

namespace fire\base;


use fire\db\Fire;

class Verify
{

    /**
     * 登录成功后数据存入session
     */
    public static function login_check($rows){
        Fire::set_session(['user'=>$rows],7200);
    }





}