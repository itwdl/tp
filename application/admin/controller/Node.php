<?php

namespace app\admin\controller;

use app\admin\controller;

//use think\Controller;
use think\Request;
use think\db;

class Node extends Admincontroller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = db('node')->field(['id', 'name', 'mname', 'aname'])->select();
        $this->assign('list', $list);
        return view('node/index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('node/add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */

    public function save(Request $request)
    {
        $data = $request->post();
        $result = db('node')->insertGetId($data);
        if ($result > 0) {
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/node/index'));
        } else {
            return $this->success('添加失败(o＞ω＜o)雅蠛蝶');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $list = db('node')->field(['id', 'name', 'mname', 'aname', 'status'])->where('id', $id)->select();

        $this->assign('list', $list['0']);
        return view('node/update');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $list = $request->put();

        $date = [
            'name' => $list['name'],
            'mname' => $list['mname'],
            'aname' => $list['aname'],
            'status'=> $list['status']
        ];

        $result = db('node')->where('id', $id)->update($date);
        if ($result > 0) {
            return $this->success('更新(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/node/index'));
        } else {
            return $this->success('更新(o＞ω＜o)雅蠛蝶');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $date = db('role_node')->field('rid')->select();
        if (!empty($date)){
            return $this->success('有角色使用此节点');
        }
        $result = db('node')->where('id', $id)->delete();
        if ($result > 0) {
            return $this->success('删除(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/node/index'));
        } else {
            return $this->success('删除(o＞ω＜o)雅蠛蝶');
        }
    }
}
