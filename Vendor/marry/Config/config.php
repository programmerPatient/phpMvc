<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 3:31
 */
return [
    //验证码长度
    'CODE_LEN' => 4,

    //默认时区
    'DEFAULT_TIME_ZONE' => 'PRC',

    //是否开启session
    'SESSION_AUTO_START' => true,

    //控制器参数名
    'VAR_CONTROLLER' => 'c',

    //控制器方法名
    'VAR_ACTION' => 'a',

    //日志开启
    'SAVE_LOG' => true,

    //错误跳转地址
    'ERROR_URL' => '',

    //错误的提示信息
    'ERROR_MESSAGE' => '网站出错了，请稍后重试..........',

    //自动加载Common/Lib下的文件，可以多加载
    'AUTO_LOAD_FILE' => array(),

    //数据库配置
    'DB_CHARSET' => 'utf8',
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => 3306,
    'DB_USER' => 'root',
    'DB_PASSWORD' => 'root',
    'DB_DATABASE' => '',
    'DB_PREFIX' => '',

    //smarty配置
    'SMARTY_ON' => true,
    'LEFT_DELIMITER' => '{',
    'RIGHT_DELIMITER' => '}',
    'CACHE_ON' => true,
    'CACHE_TIME' => 2,
];