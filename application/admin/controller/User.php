<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class User extends Controller
{
    /**
     * @return \用户列表加载
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = db('user')->field(['id', 'name','username']) ->select();
        $this->assign('list',$list);
        return view('admin@user/index');
    }


    /**
     * @return \think\response 加载添加表单
     */
    public function create()
    {

        return view('user/add');
    }

    public function save(Request $request)
    {
        // 接收数据
        $list = $request->post();
        if ($list['userpass'] != $list['repass']){return $this->success('两次密码不一致');}
        $date = [
            'username'=>$list['username'],
            'name'=>$list['name'],
            'userpass' => md5($list['userpass'])
        ];
        $result = db('user')->insertGetId($date);
        if ($result > 0) {
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/user/index'));
        } else {
            return $this->success('添加失败(o＞ω＜o)雅蠛蝶');
        }
    }

    public function edit()
    {

        return view('admin@user/update');
    }
}