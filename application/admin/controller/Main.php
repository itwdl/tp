<?php

namespace app\admin\controller;

use think\Collection;

class Main extends Collection
{
    /**
     * 后台登录页面
     * @return \think\response\View
     */
    public function index()
    {

        return view('admin@index/login');
    }

}
