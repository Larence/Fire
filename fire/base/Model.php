<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/11 0011
 * Time: 11:41
 */

namespace fire\base;

use fire\db\Fire;
use fire\db\Sql;

class Model extends Sql
{
    protected $model;

    public function __construct()
    {
        // 获取数据库名
        if (!$this->table){

            // 获取模型名称
            $this->model = get_class($this);

            // 删除类名最后的Model字符
            $this->model = substr($this,0,-5);

            // 数据库表明与类名一致
            $this->table = strtolower($this->model);
        }
    }
}