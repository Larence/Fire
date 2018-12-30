<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/11 0011
 * Time: 11:33
 */

namespace fire\base;

require "redirect.php";
class Controller
{

    protected $_controller;
    protected $_action;
    protected $_view;
    public $is_cache_page   = false;   // 是否生成静态页面
    public $layout          = true;          // 启用layout 布局
    public $layout_module   = "main";  // 布局模块
    public $title           = "";                // 页面title
    /**
     * 构造函数, 初始化属性, 并实例化对应模型
     */
    public function __construct($controller,$action)
    {
        $this->_controller  = $controller;
        $this->_action      = $action;
        $this->_view        = new View($controller,$action);
    }

    /**
     * 分配变量: assign()方法实现把变量保存到View对象中,在调用$this->render() 后视图文件就能显示这些变量。
     */
    public function assign($name,$value){
        $this->_view->assign($name,$value);
    }

    /**
     * 渲染视图
     */
    public function render(){
        $this->_view->is_cache_page = $this->is_cache_page;
        $this->_view->layout = $this->layout;
        $this->_view->layout_module = $this->layout_module;
        $this->_view->render();
    }

    /**
     * 是否启动布局
     * @param bool $layout
     */
    public function layout($layout=true){
        $this->_view->layout = $layout;
    }

    /**
     * 验证码验证
     */
    public function check_captcha($captcha){
        session_start();
        if (strtolower($captcha) != strtolower($_SESSION['captcha'])){
            return false;
        }else{
            return true;
        }
    }


}