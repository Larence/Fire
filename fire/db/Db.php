<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/11 0011
 * Time: 17:14
 */

namespace fire\db;

use fire\runtime\runtime;
use PDO;
use PDOException;

/**
 * 数据库操作类。
 * 其$pdo属性为静态属性，所以在页面执行周期内，
 * 只要一次赋值，以后的获取还是首次赋值的内容。
 * 这里就是PDO对象，这样可以确保运行期间只有一个
 * 数据库连接对象，这是一种简单的单例模式
 * Class Db
 */
class Db
{
    private static $pdo = null;

    public static function pdo(){

        if (self::$pdo != null){
            return self::$pdo;
        }

        try{
            $dsn    = sprintf("mysql:host=%s;dbname=%s;charset=utf8",DB_HOST,DB_NAME);
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

            self::$pdo = new PDO($dsn,DB_USER,DB_PASS,$option);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);//设置为警告模式
            return self::$pdo;
        }catch (PDOException $e){
            runtime::sql_log($e->getMessage());
            exit($e->getMessage());
        }
    }

}