<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12 0012
 * Time: 10:35
 */

namespace app\controllers;

use app\Models\ItemModel;
use fire\base\Controller;
use fire\db\Fire;
use fire\db\Sql;

class ItemController extends BaseController
{

    /**
     * 首页方法,测试框架自定义DB查询
     */
    public function index(){
       $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
       $item = new ItemModel();
       if ($keyword){
           $items = $item->search($keyword);
       }else{
           // 查询所有内容，并按倒序排列输出
           // where()方法可不传入参数，或者省略
           $items = $item->where()->order(['id DESC'])->fetchAll();
       }


        $this->assign('title','全部条目');
        $this->assign('keyword',$keyword);
        $this->assign('items',$items);
        $this->render();

    }


    /**
     * 查看详情
     * @param $id
     */
    public function detail($id){
        // 通过?占位符传入$id参数
        $item = new ItemModel();
        $items = $item->where(["id = ?"],[$id])->fetch();
        $this->is_cache_page=true;
        $this->assign('title','详情');
        $this->assign('item',$items);
        $this->render();
    }

    /**
     * 添加记录
     */
    public function add(){
        $data['item_name'] = $_POST['value'];

        $item = new ItemModel();
        $count = $item->insert($data);

        $this->assign('title','添加成功');
        $this->assign('count',$count);
        $this->render();
    }

    /**
     * 操作管理
     */
    public function manage($id = 0){
        $item = array();
        if ($id){
            // 通过名称占位符传入参数
            $item = (new ItemModel())->where(['id = :id'],[':id'=>$id])->fetch();
        }

        $this->assign('title','管理条目');
        $this->assign('item',$item);
        $this->render();
    }


    /**
     * 更新记录, 测试框架DB记录更新
     */
    public function update(){
        $data = array('id'=>$_POST['id'],'item_name'=>$_POST['value']);
        $count = (new ItemModel())->where(['id = :id'],[':id'=>$data['id']])->update($data);
        $this->assign('title', '修改成功');
        $this->assign('count', $count);
        $this->render();
    }


    /**
     * 删除记录，测试框架DB记录删除（Delete）
     */
    public function delete($id = null){
        $count=0;
        if ($id){
            $count = (new ItemModel())->delete($id);
        }
        $this->assign('title', '删除成功');
        $this->assign('count', $count);
        $this->render();
    }





}