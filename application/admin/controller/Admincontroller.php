<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Admincontroller extends Controller
{
    public function _initialize()
    {
        //判断session是否存在

        if(empty(session('admin_user'))){
            //跳转到 登陆页
            return view('admin@index/login');
        }

        $request = Request::instance();
        $mname = $request->controller(); //获取控制器名
        $aname = $request->action(); //获取方法名

        $nodelist = session('admin_user')['nodelist'];
        // 超管不管
        if (session('admin_user')['username'] != 'admin'){
            if(empty($nodelist[$mname]) || !in_array($aname,$nodelist[$mname])){

                $this->error("抱歉！没有操作权限！");
                exit;
            }

        }
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
