<?php

namespace app\admin\controller;

//use think\Controller;
use think\Db;
use think\Request;
use app\admin\controller;

class User extends Admincontroller
{
    /**
     * @return \用户列表加载
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = db('user')->field(['id', 'name', 'username'])->select();



       $arr = array();
        foreach ($list as $v) {

            $role_ids = db('user_role')->field(['rid'])->where('uid',$v['id'])->select();

            $roles =array();

            foreach ( $role_ids as $q){
                $roles[]=db('role')->field(['name'])->where('id',$q['rid'])->select();
            }

            $v['role'] = $roles;
            $arr[] =$v;
        }

//
        $this->assign('list', $arr);
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
        if ($list['userpass'] != $list['repass']) {
            return $this->success('两次密码不一致');
        }
        $date = [
            'username' => $list['username'],
            'name' => $list['name'],
            'userpass' => md5($list['userpass'])
        ];
        $result = db('user')->insertGetId($date);
        if ($result > 0) {
            return $this->success('添加成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/user/index'));
        } else {
            return $this->success('添加失败(o＞ω＜o)雅蠛蝶');
        }
    }

    public function edit($id)
    {
        $list = db('user')->field(['id', 'name', 'username'])->where('id', $id)->select();

        $this->assign('list', $list['0']);
        return view('user/update');
    }

    public function update(Request $request, $id)
    {
        $list = $request->put();

        $date = [
            'name' => $list['name'],
            'username' => $list['username'],

        ];

        $result = db('user')->where('id', $id)->update($date);
        if ($result > 0) {
            return $this->success('更新(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/user/index'));
        } else {
            return $this->success('更新(o＞ω＜o)雅蠛蝶');
        }
    }

    public function delete($id)
    {
        $result = db('user')->where('id', $id)->delete();
        if ($result > 0) {
            return $this->success('删除(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/user/index'));
        } else {
            return $this->success('删除(o＞ω＜o)雅蠛蝶');
        }
    }

    public function rolelist($id)
    {
        // 查询用户信息
        $user = Db::name('user')->where('id', $id)->find();

        // 查所有角色
        $date = Db::view('lamp_role', 'id,name,remark')->select();
        // 查询该用户的角色
        $list = Db::view('lamp_user_role', 'rid')
            ->view('lamp_role', "id,name", 'lamp_role.id=lamp_user_role.rid')
            ->where('uid', '=', $id)
            ->select();

        if (!empty($list)) {

            foreach ($list as $v) {
                $lists[] = $v['rid'];
            }
            $this->assign('lists', $lists);
        } else {
            $this->assign('lists', ['99999']);
        }
        $this->assign('user', $user);
        $this->assign('date', $date);

        return view('user/rolelist');
    }

    public function userrole(Request $request)
    {
        $list = $request->post();
        $id = $list['id'];
        if (empty($list['node'])) {
            return $this->success('必须添加节点', url('admin/role/rolelist', ['id' => $id]));
        }
        $node = $list['node'];
        Db::startTrans();
        try {
            db('user_role')->where('uid', $id)->delete();
            foreach ($node as $v) {
                $date['rid'] = $v;
                $date['uid'] = $id;
                $result = db('user_role')->insert($date);
            }
// 提交事务
            Db::commit();
        } catch (\Exception $e) {
// 回滚事务
            Db::rollback();
        }
        if ($result) {
            return $this->success('更新(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/user/index'));
        } else {
            return $this->success('更新失败(o＞ω＜o)雅蠛蝶');
        }


    }
}