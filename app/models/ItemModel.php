<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12 0012
 * Time: 08:46
 */
namespace app\models;


use fire\base\Model;
use fire\db\Db;

class ItemModel extends Model
{
    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 item 表
     * @var string
     */
    protected $table = 'item';

    /**
     * 搜索功能，因为Sql父类里面没有现成的like搜索，
     * 所以需要自己写SQL语句，对数据库的操作应该都放
     * 在Model里面，然后提供给Controller直接调用
     * @param $title string 查询的关键词
     * @return array 返回的数据
     */
    public function search($keyword){

        $sql = "select * from `$this->table` where `item_name` like :keyword";
        $sth = Db::pdo()->prepare($sql);

        $sth = $this->formatParam($sth,[':keyword'=> "%$keyword%"]);
        $sth->execute();
        $this->clean_cache();
        return $sth->fetchAll();
    }

    public function all(){
        $sql = "select * from $this->table where 1";
        $data = $this->query($sql);
            print_r($data);
    }

    /**
     * 清除缓存的静态文件
     */
    public function clean_cache(){
        $dir = opendir( CACHE_PATH ) or die('打开目录失败');//打开目录
        while( $file = readdir( $dir ) !== false ){ //循环读取目录中
            if ( $file != '.' && $file != '..'  ) {
                unlink( $dir . '/' . $file ); //删除文件
            }
        }
    }
}