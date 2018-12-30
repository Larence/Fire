<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/14 0014
 * Time: 14:16
 */

namespace fire\runtime;

class runtime{
    /**
     * 错误记录
     */
    public static function error_log($error){
        $filename = RUNTIME_PATH . 'error/error_log_'.date('Ymd').".txt";
//        $path = self::is_exists($filename);

        $error = date('Y-m-d H:i:s')."  ".$error;
        $handle=fopen($filename,"a+");
        $str=fwrite($handle,$error."\n");
        fclose($handle);
    }


    /**
     * sql记录
     */
    public static function sql_log($sql_error){
        if (is_array($sql_error)){
            $sql_error = implode(' ',$sql_error);
        }
        $filename = RUNTIME_PATH . 'sql/sql_log_'.date('Ymd').".txt";

        $error = date('Y-m-d H:i:s')."  ".$sql_error;
        $handle=fopen($filename,"a+");
        $str=fwrite($handle,$error."\n");
        fclose($handle);
    }


    /**
     * 判断文件夹是否存在
     * @param $filename
     * @return string
     */
    private function is_exists($filename){
        $path = RUNTIME_PATH .$filename;
        if (!file_exists($path)){
            mkdir($path,0777,true);
        }
        return $path;

    }

}
