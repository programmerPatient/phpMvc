<?php 
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 4:53
 */

class Log
{
    public static function write($msg,$level = 'ERROR',$type = 3,$dest = null){
        if(!C('SAVE_LOG')) return ;
        if(is_null($dest)){
            $dest = LOG_PATH . '/' . date('Y-m-d') . ".log";
        }
        if(is_dir(LOG_PATH)) error_log("[TIME]:" . date('Y-m-d H:i:s') . "{$level}:{$msg}\r\n",$type,$dest);
    }
}/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 3:20
 */


function halt($error,$level="error",$type=3,$dest=NULL)
{
    if(is_array($error)){
        Log::write($error['message'],$level,$type,$dest);
    }else{
        Log::write($error,$level,$type,$dest);
    }

    $e = array();
    if(DEBUG){
        if(!is_array($error)){
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['line'] = $trace[0]['line'];
            $e['class'] = isset($trace[0]['class']) ? $trace[0]['class'] : '';
            $e['function'] = isset($trace[0]['function']) ? $trace[0]['function'] : '';
            ob_start();
            debug_print_backtrace();
            $e['trace'] = htmlspecialchars(ob_get_clean());
        }else{
            $e = $error;
        }
    }else{
        if($url = C('ERROR_URL')){
            go($url);
        }else{
            $e['message'] = C('ERROR_MESSAGE');
        }
    }

    include DATA_PATH . '/Tpl/halt.html';
    die;

}

/**
 * 打印函数
 * @param $arr
 */
function p($arr)
{
    if(is_bool($arr)){
        var_dump($arr);
    }else if(is_null($arr)){
        var_dump(NULL);
    }else{
        echo '<pre style="padding:10px;border-radius:5px;background:#f5f5f5;border:1px solid #ccc;font-size:14px;">' . print_r($arr,true) .'</pre>';
    }
}

/**
 * 跳转函数
 * @param $url 跳转的地址
 * @param int $time 跳转的时间
 * @param $msg 跳转提示
 */
function go($url,$time = 0,$msg = ''){
    if(!headers_sent()){
        $time == 0 ? header('location:'.$url) : header("refresh:{$time};url={$url}");
        die($msg);
    }else{
        echo "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if($time) die($msg);
    }
}

/**
 * 1.加载配置项 优先使用用户的  默认加载框架
 * 2.读取配置项
 * 3.临时动态改变配置项
 * 4.读取所有的配置项
 */
function C($var = null, $value = null)
{
    static $config = array();
    if(is_array($var)){
        $config = array_merge($config,array_change_key_case($var,CASE_UPPER));
        return;
    }

    if(is_string($var)){
        $var = strtoupper($var);
        if(!is_null($value)){
            $config[$var] = $value;
            return;
        }
        return isset($config[$var]) ? $config[$var] : null;
    }

    if(is_null($var) && is_null($value)){
        return $config;
    }
}

function print_const()
{
    $const = get_defined_constants(true);
    p($const['user']);
}/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 4:37
 */

class BaseController
{
    /*模板参数保存*/
    protected $var = array();

    public function __construct()
    {
        if(method_exists($this,'__init')){
            $this->__init();
        }
    }

    protected function success($msg, $url = null, $time = 3)
    {
        $url = $url ? "window.location.href = '" . $url . "'" : 'window.history.back(-1)';
        include APP_PUBLIC_PATH . '/success.html';
        die;
    }

    protected function error($msg, $url = null, $time = 3)
    {
        $url = $url ? "window.location.href = '" . $url . "'" : 'window.history.back(-1)';
        include APP_PUBLIC_PATH . '/error.html';
        die;
    }

    /**
     * 模板变量传递
     * @param $var
     * @param null $value
     */
    protected function assign($var,$value=null)
    {
        if(is_array($var)){
            foreach($var as $k => $v){
                $this->var[$k] = $v;
            }
        }else{
            $this->var[$var] = $value;
        }

    }

    /**
     * 控制器模板加载
     * @param null $tpl
     */
    protected function display($tpl = null)
    {
        if(is_null($tpl)){
            $path = APP_VIEW_PATH . '/' . CONTROLLER .'/' .ACTION . '.html';
        }else{
            $suffix = strrchr($tpl,'.');
            $tpl = empty($suffix) ? $tpl .'.html' : $tpl;
            $path = APP_VIEW_PATH .'/'.CONTROLLER . '/' .$tpl;
        }
        extract($this->var);
        if(!is_file($path)) halt($path.'模板文件不存在！');
        include $path;
    }
}/**
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