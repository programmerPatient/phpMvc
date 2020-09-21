<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 3:22
 */

final class Application
{
    public static function run()
    {
        self::_init();
        self::_set_url();
        spl_autoload_register(array(__CLASS__,'autoload'));
        self::_create_demo();
        self::_app_run();
    }

    private static function _app_run()
    {
        $c = isset($_GET[C('VAR_CONTROLLER')]) ? $_GET[C('VAR_CONTROLLER')] : 'Index';
        $a = isset($_GET[C('VAR_ACTION')]) ? $_GET[C('VAR_ACTION')] : 'index';
        define('CONTROLLER',$c);
        $c .= 'Controller';
        define('ACTION',$a);
        $obj = new $c();
        $obj->$a();
    }

    /**
     * 创建默认的控制器
     */
    private static function _create_demo()
    {
        $path = APP_CONTROLLER_PATH .'/IndexController.class.php';
        $str = <<<st
<?php
class IndexController extends BaseController {
    public function index()
    {
        echo "ok";
    }
}
st;
        is_file($path) || file_put_contents($path,$str);
    }

    /**
     * 自动载入
     * @param $name 类的名字
     */
    private static function autoload($name)
    {
        include APP_CONTROLLER_PATH . '/' . $name . '.class.php';
    }

    /**
     * 初始化框架
     */
    private static function _init()
    {
        //加载配置项
        C(include CONFIG_PATH . '/config.php');
        //加载公共配置项
        $commonPath = COMMON_CONFIG_PATH . '/config.php';
        $commonConfig = <<<str
<?php 
return array(
    //配置项 => 配置值
);
str;
        is_file($commonPath) || file_put_contents($commonPath,$commonConfig);
        C(include $commonPath);

        $userConfPath = APP_CONFIG_PATH . '/config.php';
        $userConfig = <<<str
<?php 
return array(
    //配置项 => 配置值
);
str;
        is_file($userConfPath) || file_put_contents($userConfPath,$userConfig);
        //加载用户的配置项
        C(include $userConfPath);

        //设置默认时区
        date_default_timezone_set(C('DEFAULT_TIME_ZONE'));

        //开启session
        C('SESSION_AUTO_START') && session_start();
    }

    /**
     * 设置url
     */
    private  static function _set_url()
    {
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        $path = str_replace('\\','/',$path);
        define('__APP__',$path);
        define('__ROOT__',dirname(dirname(__APP__)));
        if(empty(APP_NAME)){
            define('__TPL__',__ROOT__ . '/app/Public');
        }else{
            define('__TPL__',__ROOT__ . '/app/' . APP_NAME . '/Public');
        }
//        define('__PUBLIC__', __TPL__ . '/Public');
        //公共文件路径
        define('ROOT_PUBLIC_PATH', __ROOT__ . '/Public');
    }
}
?>