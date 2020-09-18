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
        defined(DEBUG) || define('DEBUG',false);
        if(DEBUG){
            self::_create_dir();
            self::_import_file();
        }else{
            error_reporting(0);
            require TEMP_PATH . '/~boot.php';
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
    }

    /**
     * 生成框架文件夹模板
     */
    private static function _create_dir()
    {
        $arr = array(
            APP_PATH,
            APP_CONFIG_PATH,
            APP_CONTROLLER_PATH,
            APP_PUBLIC_PATH,
            TEMP_PATH,
            LOG_PATH,
        );
        foreach($arr as $v){
            is_dir($v) || mkdir($v, 0777,true);
        }
    }

    /**
     * 载入框架所需文件
     */
    private static function _import_file()
    {
        $fileArr = array(
            FUNCTION_PATH . '/function.php',
            CORE_PATH . '/BaseController.php',
            CORE_PATH . '/Application.php'
        );
        foreach($fileArr as $v){
            require_once $v;
        }
    }
}
Marry::run();