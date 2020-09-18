<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 3:20
 */
function p($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '<pre>';
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