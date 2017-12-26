<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Role extends Controller
{
    public function index()
    {
        $list = db('role')->field(['id', 'name','status', 'remark'])->select();
        $this->assign('list',$list);
        return view('role/index');
    }

    public function create()
    {
        return view('role/add');
    }

    public function save(Request $request)
    {
        $list = $request->post();
        $result = db('role')->insertGetId($list);

        if ($result > 0) {
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/role/index'));
        } else {
            return $this->success('添加失败(o＞ω＜o)雅蠛蝶');
        }
    }
    public function nodelist($id)
    {

        $role = Db::view('role','name')
            ->view('node', 'id ,name, mname, aname')
            ->view('role_node','nid,rid')
            ->where('nid','=','id')

            ->where('rid', '=',$id)
            ->select();
        var_dump($role);die;
        return view('role/nodelist');
    }

}
