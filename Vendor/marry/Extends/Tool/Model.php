<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/22 0022
 * Time: 下午 12:01
 */

class Model{

    //保存连接信息
    public static $link = null;

    //保存表名
    protected $table = null;

    //初始化表信息
    private $opt;

    //记录发送的sql
    public static $sql = array();

    public function __construct($table=null)
    {
        $this->table = is_null($table) ? C("DB_PREFIX") . $this->table : C("DB_PREFIX") . $table;
        //连接数据库
        $this->_connect();
        //初始化sql的信息
        $this->_opt();
    }

    public function query($sql)
    {
        self::$sql[] = $sql;
        $link = self::$link;
        $result = $link->query($sql);
        if($link->error) halt('mysql错误：' . $link->error . '<br/>SQL:' . $sql);
        $rows = array();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        $this->_opt();
        return $rows;
    }

    /**
     * 查询条数
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->opt['limit'] = ' ORDER BY ' . $limit;
        return $this;
    }

    /**
     * 只取一条
     * @return array|mixed
     */
    public function find()
    {
        $data = $this->limit(1)->all();
        $data = current($data);
        return $data;
    }

    /**
     * 排序查询
     * @param $order
     * @return $this
     */
    public function order($order)
    {
        $this->opt['order'] = ' ORDER BY ' . $order;
        return $this;
    }

    /**
     * 条件查询
     * @param $where
     * @return $this
     */
    public function where($where)
    {
        $this->opt['where'] = ' where ' . $where;
        return $this;
    }

    /**
     * 查询指定字段的结果集
     * @param $field
     * @return $this
     */
    public function field($field)
    {
        $this->opt['field'] = $field;
        return $this;
    }

   /**
     * 获取所有数据
     * @return array
     */
    public function all()
    {
        $sql = "SELECT " . $this->opt['field'] . " FROM " . $this->table . $this->opt['where'] . $this->opt['group'] . $this->opt['having'] . $this->opt['order'] . $this->opt['limit'];
        return $this->query($sql);
    }

    /**
     * 初始化sql信息
     */
    private function _opt()
    {
        $this->opt = [
            'field' => '*',
            'where' => '',
            'group' => '',
            'having' => '',
            'order' => '',
            'limit' => '',
        ];
    }

    /**
     * 连接数据库
     */
    private function _connect()
    {
        if(is_null(self::$link)){
            if(empty(C('DB_DATABASE'))) halt("请先配置数据库");
            $link = new Mysqli(C('DB_HOST'),C('DB_USER'),C("DB_PASSWORD"),C("DB_DATABASE"),C("DB_PORT"));
            if($link->connect_error) halt("数据库连接错误，请检查配置项");
            $link->set_charset(C("DB_CHARSET"));
            self::$link = $link;
        }
    }


    public function exe($sql)
    {
        self::$sql[] = $sql;
        $link = self::$link;
        $bool = $link->query($sql);
        $this->_opt();
        if(is_object($bool)){
            halt("请用query方法发送查询的sql");
        }
        if($bool){
            return $link->insert_id ?:$link->affected_rows;
        }else{
            halt("mysql错误：".$link->error . '<br/>SQL: '. $sql);
        }
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        if(empty($this->opt['where'])){
            halt("删除语句必须有where条件");
        }
        $sql = "DELETE FROM " . $this->table . $this->opt['where'];
        return $this->exe($sql);
    }

    /**
     * 增加
     */
    public function add($data=null)
    {
        if(is_null($data))
            $data = $_POST;
        $field = '';
        $values = '';
        foreach($data as $k => $v){
            $field .= "`" . $this->_safe_str($k) . "`,";
            $values .= "'". $this->_safe_str($v) . "',";
        }
        $field = trim($field,',');
        $values = trim($values,',');
        $sql = "INSERT INTO " . $this->table . " (" .$field. ") VALUES (".$values. ")";
        return $this->exe($sql);
    }

    /**
     * 数据更新
     * @param null $data
     */
    public function update($data = null)
    {
        if(empty($this->opt['where'])){
            halt("删除语句必须有where条件");
        }
        if(is_null($data))
            $data = $_POST;
        $values = '';
        foreach($data as $k => $v){
            $values .= "`". $this->_safe_str($k) . "`='".$this->_safe_str($v)."',";
        }
        $values = trim($values,',');
        $sql = "UPDATE " . $this->table . " SET " . $values . $this->opt['where'];
        return $this->exe($sql);

    }

    /**
     * 安全处理
     * @param $str
     */
    private function _safe_str($str)
    {
        if(get_magic_quotes_gpc()){
            $str = stripslashes($str);
        }

        return self::$link->real_escape_string($str);
    }


}