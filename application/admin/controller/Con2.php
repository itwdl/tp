<?php

namespace app\admin\controller;

use think\Controller;

class Con2 extends Controller
{
    public function func1()
    {
        $list = db('role')->field(['id', 'name','status', 'remark'])->select();
        $this->assign('list',$list);
        return view('admin@con2/func1');
    }

    public function func2()
    {
        return view('admin@con2/func2');
    }
}
