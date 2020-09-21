<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 2:26
 */
final class Marry {
    public static function run()
    {
        self::_set_const();
        defined('DEBUG') || define('DEBUG',false);
        if(DEBUG){
            self::_create_dir();
            self::_import_file();
        }else{
            //屏蔽所有错误
            require TEMP_PATH . '/~boot.php';
            error_reporting(0);
        }
        Application::run();
    }

    /**
     * 设置框架常量
     */
    private static function _set_const()
    {
        $path = str_replace('\\','/',__FILE__);
        define('KERNEL_PATH',dirname($path));
        define('CONFIG_PATH',KERNEL_PATH . '/Config');
        define('DATA_PATH',KERNEL_PATH . '/Data');
        define('LIB_PATH',KERNEL_PATH . '/Lib');
        define('CORE_PATH',LIB_PATH . '/Core');
        define('FUNCTION_PATH',LIB_PATH . '/Function');

        //项目根目录
        define('ROOT_PATH',dirname(dirname(KERNEL_PATH)));

        //临时目录
        define('TEMP_PATH',ROOT_PATH . '/Temp');
        //日志目录
        define('LOG_PATH',TEMP_PATH . '/Log');

        if(empty(APP_NAME)){
            define('APP_PATH', ROOT_PATH . '/app');
        }else{
            define('APP_PATH', ROOT_PATH . '/app/' . APP_NAME);
        }
        define('APP_CONFIG_PATH',APP_PATH . '/Config');
        define('APP_CONTROLLER_PATH', APP_PATH . '/Controller');
        define('APP_PUBLIC_PATH', APP_PATH . '/Public');
        define('APP_VIEW_PATH', APP_PATH . '/View');

        //创建公共
        define('COMMON_PATH',ROOT_PATH . '/Common');
        //公共配置项文件夹
        define('COMMON_CONFIG_PATH',COMMON_PATH . '/Config');
        //公共模型文件夹
        define('COMMON_MODEL_PATH',COMMON_PATH . '/Model');
        //公共库文件夹
        define('COMMON_LIB_PATH',COMMON_PATH . '/Lib');

        define('MARRYPHP_VERSION','1.0');

        define('IS_POST',$_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
            define('IS_AJAX',true);
        }else{
            define('IS_AJAX',false);
        }


    }

    /**
     * 生成框架文件夹模板
     */
    private static function _create_dir()
    {
        $arr = array(
            COMMON_CONFIG_PATH,
            COMMON_MODEL_PATH,
            COMMON_LIB_PATH,
            APP_PATH,
            APP_CONFIG_PATH,
            APP_CONTROLLER_PATH,
            APP_PUBLIC_PATH,
            APP_VIEW_PATH,
            TEMP_PATH,
            LOG_PATH,
        );
        foreach($arr as $v){
            is_dir($v) || mkdir($v, 0777,true);
        }
        is_file(APP_PUBLIC_PATH . '/success.html') || copy(DATA_PATH . '/Tpl/success.html',APP_PUBLIC_PATH . '/success.html');
        is_file(APP_PUBLIC_PATH . '/error.html') || copy(DATA_PATH . '/Tpl/error.html',APP_PUBLIC_PATH . '/error.html');
    }

    /**
     * 载入框架所需文件
     */
    private static function _import_file()
    {
        $fileArr = array(
            CORE_PATH . '/Log.php',
            FUNCTION_PATH . '/function.php',
            CORE_PATH . '/BaseController.php',
            CORE_PATH . '/Application.php',
        );
        $str = '';
        foreach($fileArr as $v){
            $str .= trim(substr(file_get_contents($v),5,-2));
            require_once $v;
        }
        $str = "<?php \r\n" . $str;
        file_put_contents(TEMP_PATH.'/~boot.php',$str) || die('access not allow');
    }
}
Marry::run();