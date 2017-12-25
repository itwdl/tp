<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;

class Con1 extends Controller
{
    /**
     * @return \用户列表加载
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = db('user')->field(['id', 'name','username'])->select();
        $this->assign('list',$list);
        return view('admin@con1/tables');
    }

    public function func1()
    {
        $list = db('node')->field(['id', 'name','mname', 'aname'])->select();
        $this->assign('list',$list);
        return view('admin@con1/func1');
    }

    public function func2()
    {
        return view('admin@con1/func2');
    }

}