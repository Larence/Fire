<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/18 0018
 * Time: 16:59
 */

namespace app\controllers;


use app\models\UserModel;
use fire\base\Captcha;
use fire\base\Controller;
use fire\base\Verify;
use fire\db\Fire;

class SiteController extends Controller
{

    /**
     * 验证码
     */
    public function captcha(){
        Captcha::set_captcha();
    }

    /**
     * 登录页面
     */
    public function login(){
        if ($_SERVER['REQUEST_METHOD']=="POST"){
            $username = $_POST["username"];
            $password = $_POST["password"];
            $captcha  = $_POST['captcha'];

            if ($username == "" || $password == "" || $captcha == ""){
                echo"<script type='text/javascript'>alert('不能存在空项');location='/site/login'; </script>";
            }
            if(!$this->check_captcha($captcha)) //判断填写的验证码是否与验证码PHP文件生成的信息匹配
            {
                echo "<script type='text/javascript'>alert('验证码错误!');location='/site/login';</script>";
            }

            $rows = (new UserModel())->where(['username=:username'],[':username'=>$username])->fetch();
            if ($username == $rows['username'] && md5($password) == $rows['password']){
                Verify::login_check($rows);
                header('Location: /home/index');
            }
        }
        $this->layout = false;
        $this->render();
    }


    public function logout(){
        Fire::logout();
        header("location:/");
    }



}