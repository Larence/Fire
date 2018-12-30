<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/18 0018
 * Time: 16:57
 * 登录页面
 */
?>
<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="zh-CN" />
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <title>Login</title>
    <style>
        html{
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-style: sans-serif;
        }
        body{
            width: 100%;
            height: 100%;
            font-family: 'Open Sans',sans-serif;
            margin: 0;
            background-color: #4A374A;
        }
        #login{
            position: absolute;
            top: 50%;
            left:50%;
            margin: -150px 0 0 -150px;
            width: 300px;
            height: 300px;
        }
        #login h1{
            color: #fff;
            text-shadow:0 0 10px;
            letter-spacing: 1px;
            text-align: center;
        }
        h1{
            font-size: 2em;
            margin: 0.67em 0;
        }
        .form-horizontal input{
            width: 278px;
            height: 18px;
            margin-bottom: 10px;
            outline: none;
            padding: 10px;
            font-size: 13px;
            color: #fff;
            text-shadow:1px 1px 1px;
            border-top: 1px solid #312E3D;
            border-left: 1px solid #312E3D;
            border-right: 1px solid #312E3D;
            border-bottom: 1px solid #56536A;
            border-radius: 4px;
            background-color: #2D2D3F;
        }
        #captcha{
            width: 139px;
            float: left;
        }
        #captcha_img{
            margin-left: 30px;
            float: left;
            border-radius: 3px;
        }
        .but{
            width: 300px;
            min-height: 20px;
            display: block;
            background-color: #4a77d4;
            border: 1px solid #3762bc;
            color: #fff;
            padding: 9px 14px;
            font-size: 15px;
            line-height: normal;
            border-radius: 5px;
            margin: 0;
        }
    </style>
</head>
<body>
<div id="login">
    <h1>Login</h1>
    <form action="login" class="form-horizontal" method="post">
        <input type="text" required="required" placeholder="用户名" name="username">
        <input type="password" required="required" placeholder="密码" name="password">
        <input type="text" required="required" name="captcha"  id="captcha"  placeholder="验证码"  />
        <a href="#" onclick="javascript:reflash()">
            <img id="captcha_img" name="captcha_img"  alt="看不清楚，换一张"  border="1" src="/site/captcha" width=100 height=37>
        </a>
        <button id="b_login" class="but" type="submit">登录</button>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    //alert($)
    function reflash(){
        var change = document.getElementById('captcha_img');
        change.src="/site/captcha";
    }
    $(document).ready(function(){//页面加载完成再加载脚本
        /*点击登录按钮后做的事件处理*/
        $('#b_login').click(function(event){
            var $name = $('input[name="username"]');
            var $password = $('input[name="password"]');
            var $captcha =  $('input[name="captcha"]');
            var $text = $(".text");
            var _name = $.trim($name.val());//去掉字符串多余空格
            var _password = $.trim($password.val());
            var _captcha_img =  $.trim($captcha.val());

            if(_name==''){
                alert('请输入用户名');
                $name.focus();
                return false;
            }
            if(_password==''){
                alert('请输入密码');
                $password.focus();
                return false;
            }
            if(_captcha_img==""){
                alert('请输入验证码');
                $captcha.focus();
                return false;
            }


        });

    });
</script>


