<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/20 0020
 * Time: 09:25
 */

/**
 * URL跳转
 * @param string $url 跳转地址
 * @param int $time 跳转延时(单位:秒)
 * @param string $msg 提示语
 */
function redirect($url, $time = 0, $msg = ''){
    $url = str_replace(array("\n", "\r"), '', $url); // 多行URL地址支持
    if (empty($msg)) {
        $msg = "系统将在 {$time}秒 之后自动跳转到 {$url} ！";
    }
    if (headers_sent()) {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0) {
            $str .= $msg;
        }
        exit($str);
    } else {
        if (0 === $time) {
            header("Location: " . $url);
        } else {
            header("Content-type: text/html; charset=utf-8");
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    }

}