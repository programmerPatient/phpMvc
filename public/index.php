<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/17 0017
 * Time: 下午 3:52
 */
//调试模式开启
define('DEBUG',true);

define('APP_NAME','');
//载入核心类入口文件
//require dirname(dirname(str_replace('\\','/',__FILE__))) . "/Vendor/marry/marry.php";
require dirname(__DIR__) . '/Vendor/autoload.php';
\Marry\Marry::run();