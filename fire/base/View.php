<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/11 0011
 * Time: 17:23
 */

namespace fire\base;

/**
 * 视图基类
 * Class View
 * @package fire\base
 */
class View
{
    protected $variables = array();
    protected $_controller;
    protected $_action;
    public $layout          = true;
    public $is_cache_page   = false; // 是否生成静态页
    public $layout_module   = "main";
    public $title           = "";

    function __construct($controller,$action)
    {
        $this->_controller  = strtolower($controller);
        $this->_action      = strtolower($action);
    }

    /**
     * 分配变量
     */
    public function assign($name,$value){
        $this->variables[$name] = $value;
    }

    /**
     * 渲染显示
     */
    public function render(){

        $layoutFile = APP_PATH . "app/views/layout/".$this->layout_module.".php";
        $viewFile = APP_PATH . "app/views/" . $this->_controller . "/" . $this->_action . ".php";

        // 判断视图文件是否存在
        if (is_file($viewFile)){
           $output = $this->renderInternal($viewFile,$this->variables);
           if (is_file($layoutFile) && $this->layout == true){
               $output = $this->renderInternal($layoutFile,array('content'=>$output,'title'=>$this->title));
           }
            //获取url域名外的剩余部分
            $url = $_SERVER['REQUEST_URI'];

            $cache_path = CACHE_PATH."/".md5($url).".php";
           if (is_file($cache_path)){
               include ($cache_path);
           }else{
               if ($this->is_cache_page){ // 是否需要生成静态页
                   file_put_contents($cache_path,$output);
               }
               echo $output;
           }
        }else{
            echo "<h1>无法找到视图文件{$viewFile}</h1>";
        }


    }



    /**
     * 解析和获取页面内容 字符串输入页面内容
     */
    public function renderInternal($path,$variables){
        extract($variables);
        ob_start();
        ob_implicit_flush(false);
        require($path);
        return ob_get_clean();
    }

}