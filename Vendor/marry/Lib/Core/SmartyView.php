<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/22 0022
 * Time: 下午 4:04
 */

class SmartyView
{
    private static $smarty = null;
    public function __construct()
    {
        if(!is_null(self::$smarty)) return;
        $smarty = new Smarty();
        //模板目录
        $smarty->template_dir = APP_VIEW_PATH . '/' . CONTROLLER .'/';
        //编译
        $smarty->compile_dir = APP_COMPILE_PATH;
        //缓存
        $smarty->cache_dir = APP_CACHE_PATH;
        $smarty->left_delimiter = C('LEFT_DELIMITER');
        $smarty->right_delimiter = C('RIGHT_DELIMITER');
        $smarty->caching = C('CACHE_ON');
        $smarty->cache_lifetime = C('CACHE_TIME');
        self::$smarty = $smarty;
    }

    protected function display($tpl)
    {
        self::$smarty->display($tpl,$_SERVER['REQUEST_URI']);
    }

    protected function assign($var,$value)
    {
        self::$smarty->assign($var,$value);
    }

    protected function is_cached($tpl=null)
    {
        if(!C('SMARTY_ON')) halt('请先开启smarty模板');
        $tpl = $this->get_tpl($tpl);
        return self::$smarty->isCached($tpl,$_SERVER['REQUEST_URI']);
    }
}