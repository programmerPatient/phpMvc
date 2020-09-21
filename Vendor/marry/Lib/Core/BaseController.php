<?php
/**
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
}
?>