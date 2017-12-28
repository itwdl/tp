<?php

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Index extends Controller
{
    /**
     * 后台登录处理
     * @return \think\response\View
     */
    public function logindo(Request $request)
    {
        $name = $request->post('username');
        $pass = $request->post('userpass');
        $captcha =$request->post('captcha');

        if(!captcha_check($captcha)){

//验证失败
            return $this->success("验证码错误", url('admin/index/index'));
        };


        $date = db('user')->where('username', $name)->where('userpass', md5($pass))->find();
        $id = $date['id'];

        if (empty($date)) {
            $this->success("用户名密码不正确", url('admin/index/index'));
        }

        session('admin_user', $date, 'think');


        $sql = "select n.mname,n.aname from lamp_user u join lamp_user_role ur on u.id=ur.uid join lamp_role_node rn on ur.rid=rn.rid join lamp_node n on rn.nid=n.id where u.id={$id}";
        $list = Db::query($sql);
        foreach ($list as $key => $val) {
            $list[$key]['mname'] = ucfirst($val['mname']);
        }
        $nodelist = array();
        $nodelist['Index'] = array('index');
        foreach($list as $v){
            $nodelist[$v['mname']][] = $v['aname'];
            //把修改和执行修改 添加和执行添加 拼装到一起
            if($v['aname']=="edit"){
                $nodelist[$v['mname']][]="update";
            }
            if($v['aname']=="create"){
                $nodelist[$v['mname']][]="save";
            }
        }
        $date['nodelist'] = $nodelist;
        session('admin_user', $date, 'think');
//        return view('admin@main/index');
//        return $this->redirect('admin/main/index');
        return $this->success('登录成功','admin/index/index');
    }

    /**
     * 后台登出处理
     * @return \think\response\View
     */
    public function logout()
    {
        Session::clear('think');
        return $this->redirect('admin/index/index');
    }

    /**
     * 后台主页
     * @return \think\response\View
     */
    public function index()
    {


        if(empty(session('admin_user'))){
            //跳转到 登陆页
            return view('admin@index/login');
        }
        return view('admin@main/index');
    }

}
