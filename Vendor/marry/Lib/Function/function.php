<?php
/**
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

/**
 * 获取所有常量
 */
function print_const()
{
    $const = get_defined_constants(true);
    p($const['user']);
}

function M($table)
{
    $obj = new Model($table);
    return $obj;
}

function K($model)
{
    $model = $model . 'Model';
    return new $model;
}



?>