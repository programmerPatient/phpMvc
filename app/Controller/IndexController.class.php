<?php
class IndexController extends BaseController {
    public function index()
    {
        if(!$this->is_cached()){

        }
        $this->assign(['var'=>time()]);
        $this->display();
    }

    public function text()
    {
        echo 'sss';
    }


}