<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\db;

class Node extends Controller
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
        return view('node/edit');
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


        $date = db('node')->where('id', $id)->update($list);
        var_dump($date);
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete1($id)
    {
        dump('$id');
    }
}
