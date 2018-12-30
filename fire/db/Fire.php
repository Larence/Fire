<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17 0017
 * Time: 08:49
 * 查询方法---对外接口
 */

namespace fire\db;

use fire\db\Sql;
class Fire
{

    /**
     * 初始化sql;
     * @return \fire\db\Sql
     */
    public static function init(){
        return new Sql();
    }

    /**
     * 查询条件拼接，使用方式：
     *
     * $this->where(['id = 1','and title="Web"', ...])->fetch();
     * 为防止注入，建议通过$param方式传入参数：
     * $this->where(['id = :id'], [':id' => $id])->fetch();
     *
     * @param array $where 条件
     * @return $this 当前对象
     */
    public static function where($where = array(),$param = array()){
        self::$sql->where($where,$param);
    }


    /**
     * 拼装排序条件，使用方式：
     *
     * $this->order(['id DESC', 'title ASC', ...])->fetch();
     *
     * @param array $order 排序条件
     * @return $this
     */
    public static function order($order = array()){
        self::init()->order($order);
    }



    /**
     * 查询所有
     */
    public static function fetchAll(){
        self::init()->fetchAll();
    }

    /**
     * 查询一条数据
     */
    public static function fetch(){
      self::init()->fetch();
    }

    /**
     * 根据条件(id) 删除
     */
    public static function delete($id){
        self::init()->delete($id);
    }

    /**
     * 新增数据
     */
    public static function insert($data){
        self::init()->insert($data);
    }

    /**
     * 修改数据
     */
    public static function update($data){
        self::init()->update($data);
    }

    /**
     * 执行原生sql语句
     * @param $sql
     * @return array
     */
    public static function query($sql){
        return self::init()->query($sql);
    }


    /**
     * 设置 session
     * @param array $param
     * @param $expiretime  session过期时间
     * @return string
     */
    public static function set_session($param = array(),$expiretime=0){

        if (!is_array($param) || count($param)!=1){
            return "请传入正确的参数";
        }
        self::session_start();
        if ($expiretime){
         $_SESSION['expiretime'] = time()+$expiretime;
        }
        foreach ($param as $key => $value){
            $_SESSION[$key] = $value;
        }

    }

    /**
     * 获取session
     * @param $name
     * @return mixed
     */
    public static function get_session($name){
        self::session_start();
        if(isset($_SESSION[$name])){
            return  $_SESSION[$name];
        }else{
            return "";
        }
    }


    /**
     * 清除某个session
     * @param  String  $name  session name
     */
    public static function clear_session($name){
        self::session_start();
        unset($_SESSION[$name]);
    }

    /**
     * 获取登录是否登录
     */
    public static function check_login(){
        $user = self::get_session('user');
        if ($user){
            if (self::get_session('expiretime') < time()){
                self::logout();
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }



    /**
     * 清空登录信息
     */
    public static function logout(){
        self::session_start();
        $_SESSION = array(); //清除SESSION值.
        session_unset();//free all session variable
        session_destroy();//销毁一个会话中的全部数据
    }

    /**
     * session_start()
     */
    public static function session_start(){
        if (!session_id()){
            session_start();
        }
    }





}