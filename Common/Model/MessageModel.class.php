<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/22 0022
 * Time: 下午 3:44
 */
class MessageModel extends Model{

    public $table = 'cate';

    public function get_all_data()
    {
        return $this->all();
    }

}