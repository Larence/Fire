<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10 0010
 * Time: 15:36
 * 入口文件
 */

// 应用目录为当前目录
define('APP_PATH', __DIR__ . '/');

// 开启调试模式
define('APP_DEBUG',true);


// 加载框架
require(APP_PATH . 'fire/Firephp.php');

// 加载配置文件
$config = require(APP_PATH . 'config/config.php');
// 实例化框架类
(new fire\Firephp($config))->run();
