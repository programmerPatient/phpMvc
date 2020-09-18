<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/18 0018
 * Time: 下午 4:59
 */

class Log{
    public static function write($msg,$level = 'ERROR', $type = 3, $dest = null)
    {
        if(!C('SAVE_LOG')) return;
        if(is_null($dest)){
            $dest = LOG_PATH . '/' . date('Y_m_d') . ".log";
        }

        if(is_dir(LOG_PATH)) error_log("[TIME]:" . date('Y-m-d H:i:s') . " {$level}:{$msg}\r\n",$type,$dest);
    }
}
