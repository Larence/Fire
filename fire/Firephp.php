<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10 0010
 * Time: 15:40
 * 框架统一文件
 */
namespace fire;

// 框架根目录
use fire\runtime\runtime;

defined('CORE_PATH') or define('CORE_PATH',__DIR__);
// 运行时缓存目录
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH.'runtime/');

// 静态页面缓存路径
defined('CACHE_PATH') or define('CACHE_PATH', APP_PATH.'runtime/cache');

/**
 * 框架核心
 * Class Firephp
 * @package fire
 */
class Firephp
{

    // 配置内容
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    // 运行程序
    public function run()
    {
        // spl_autoload_register函数是实现自动加载未定义类功能的的重要方法
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();  // 检测开发环境
        $this->removeMagicQuotes(); // 检测敏感字符并删除
        $this->unregisterGlobals(); // 移除全局变量的老用法
        $this->setDbConfig();       // 配置数据库信息
        $this->route();
    }

    /**
     * 路由处理:截取URL，并解析出控制器名、方法名和URL参数
     */
    public function route()
    {
        $controllerName = $this->config['defaultController'];
        $actionName = $this->config['defaultAction'];
        $param = array();

        $_url = $_SERVER['REQUEST_URI'];
        // 清除?之后的内容
        $position = strpos($_url, '?'); // 查找?在url中第一次出现的位置
        // 参数
        $url = $position === false ? $_url : substr($_url, 0, $position);

        // 使得可以这样访问 index.php/{controller}/{action}
        $position = strpos($url, 'index.php');
        if ($position !== false) {
            $url = substr($url, $position + strlen('index.php'));
        }

        // 删除前后的“/”
        $url = trim($url,'/');

        if ($url) {
            // 使用"/"分割字符串,并保存在数组中
            $urlArray = explode('/', $url);
            // 删除数组中的空元素
            $urlArray = array_filter($urlArray);

            // 获取控制器名
            $controllerName = ucfirst($urlArray[0]);

            // 获取动作名(方法名)
            array_shift($urlArray);
            $actionName = $urlArray ? $urlArray[0] : $actionName;
            // 获取url参数
            array_shift($urlArray);
            $param = $urlArray ? $urlArray : array();
        }

        // 判断控制器和操作是否存在
        $controller = 'app\\controllers\\' . $controllerName . 'Controller';
        if (!class_exists($controller)) {
            runtime::error_log($controller . '控制器不存在');
            exit($controller . '控制器不存在');
        }
        if (!method_exists($controller, $actionName)) {
            runtime::error_log($actionName . '方法不存在');
            exit($actionName . '方法不存在');
        }
        /**
         * 如果存在缓存文件则直接走缓存文件
         */
        $cache_path = CACHE_PATH."/".md5($_url).".php";

        if (is_file($cache_path)) {
            $time = filectime($cache_path); // 获取文件创建时间(超过300s则删除)
            if ((time()-$time)>300){
                unlink($cache_path);
            }else{
                include($cache_path);
                exit();
            }
        }
        /**
         * 如果控制器和操作名存在, 则实例化控制器, 因为控制器对象里面
         * 还会用到控制器名和操作名, 所以实例化的时候把他们两的名称也
         * 传进去. 结合Controller基类一起看
         */
        $dispatch = new $controller($controllerName, $actionName);

        /**
         * $dispatch保存控制器实例化后的对象, 我们就可以调用它的方法,
         * 也可以像方法中传入参数, 以下等同于 : $dispatch->$actionName($param)
         */
        call_user_func_array(array($dispatch, $actionName), $param);

    }

    /**
     * 检测开发环境
     */
    public function setReporting()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', RUNTIME_PATH .'logs/error.log');
        }
    }

    /**
     * 删除敏感字符
     */
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    /**
     * 检测敏感字符并删除
     */
    public function removeMagicQuotes()
    {
        // get_magic_quotes_gpc函数是一个用来判断是否为用户提供的数据增加斜线了，这个在php.ini配置文件中
        // 取得 PHP 环境变数 magic_quotes_gpc 的值，属于 PHP 系统功能。
        // magic_quotes_gpc (GPC, Get/Post/Cookie) 值。返回 0 表示关闭本功能；返回 1 表示本功能打开。
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    /**
     * 检测自定义全局变量并移除。因为 register_globals 已经弃用，如果
     * 已经弃用的 register_globals 指令被设置为 on，那么局部变量也将
     * 在脚本的全局作用域中可用。 例如， $_POST['foo'] 也将以 $foo 的
     * 形式存在，这样写是不好的实现，会影响代码中的其他变量。 相关信息，
     * 参考: http://php.net/manual/zh/faq.using.php#faq.register-globals
     */
    public function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    /**
     * 配置数据库信息
     */
    public function setDbConfig()
    {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    /**
     * 自动加载类
     */
    public function loadClass($className)
    {
        $classMap = $this->classMap();

        if (isset($classMap[$className])) {
            // 包含内核文件
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            // 包含应用(app目录)文件
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($file)) {
                return;
            }
        } else {
            return;
        }
        include $file;
        // 这里可以加入判断，如果名为$className的类、接口或者性状不存在，则在调试模式下抛出错误
    }

    /**
     * 内核文件命名空间映射关系
     */
    protected function classMap()
    {
        return [
            'fire\base\Controller' => CORE_PATH . '/base/Controller.php',
            'fire\base\Model' => CORE_PATH . '/base/Model.php',
            'fire\base\View' => CORE_PATH . '/base/View.php',
            'fire\db\Db' => CORE_PATH . '/db/Db.php',
            'fire\db\Sql' => CORE_PATH . '/db/Sql.php'
        ];
    }

    /**
     * 格式化参数为数组
     * @param $query
     * @return array
     */
    protected function convertUrlArray($query)
    {
        $params = array();
        if (empty($query)){
            return $params;
        }
        $queryParts = explode('&', $query);
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

}