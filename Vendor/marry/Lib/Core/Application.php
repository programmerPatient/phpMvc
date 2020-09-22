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
        set_error_handler(array(__CLASS__,'error'));
        register_shutdown_function(array(__CLASS__,'fatal_error'));
        self::_set_url();
        spl_autoload_register(array(__CLASS__,'autoload'));
        self::_create_demo();
        self::_user_import();
        self::_app_run();
    }

    public static function fatal_error()
    {
        if($e = error_get_last()){
            self::error($e['type'],$e['message'],$e['file'],$e['line']);
        }
    }

    public static function error($errno,$error,$file,$line)
    {
        switch ($errno){
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                $msg = $error . $file . "第{$line}行";
                halt($msg);
                break;
            case E_STRICT:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            default:
                if(DEBUG){
                    include DATA_PATH . '/Tpl/notice.html';
                }
                break;
        }
    }

    private static function _app_run()
    {
        $c = isset($_GET[C('VAR_CONTROLLER')]) ? $_GET[C('VAR_CONTROLLER')] : 'Index';
        $a = isset($_GET[C('VAR_ACTION')]) ? $_GET[C('VAR_ACTION')] : 'index';
        define('CONTROLLER',$c);
        $c .= 'Controller';
        define('ACTION',$a);
        if(class_exists($c)){
            $obj = new $c();
            if(!method_exists($obj,$a)){
                if(method_exists($obj,'__empty')){
                    $obj->__empty();
                }else{
                    halt($c.'控制器下的'.$a."方法不存在");
                }
            }else{
                $obj->$a();
            }
        }else{
            $obj = new EmptyController();
            $obj->index();
        }

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
        switch (true){
            case strlen($name) > 10 && substr($name,-10) == 'Controller':
                $path = APP_CONTROLLER_PATH . '/' . $name . '.class.php';
                if(!is_file($path)) {
                    $emptyPath = APP_CONTROLLER_PATH . '/EmptyController.class.php';
                    if(is_file($emptyPath)){
                        include $emptyPath;
                    }else{
                        halt($path,'控制器未找到');
                    }
                }else
                    include $path;
                break;
            case  strlen($name) > 5 && substr($name,-5) == 'Model':
                $path = COMMON_MODEL_PATH . '/' . $name . '.class.php';
                if(!is_file($path)) {
                    halt($path,'模型未找到');
                }else
                    include $path;
                break;
            default:
                $path = TOOL_PATH . '/' . $name . '.php';
                if(!is_file($path)) halt($path,'类未找到');
                include $path;
                break;
        }

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

    private static function _user_import()
    {
        $fileArr = C('AUTO_LOAD_FILE');
        if(is_array($fileArr) && !empty($fileArr)){
            foreach ($fileArr as $v){
                require_once COMMON_LIB_PATH . '/' . $v;
            }
        }
    }
}
?>