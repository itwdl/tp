<?php

namespace app\admin\controller;

//use think\Controller;
use think\Db;
use think\Request;

class Role extends Admincontroller
{
    public function index()
    {
        $list = db('role')->field(['id', 'name', 'status', 'remark'])->select();
        $this->assign('list', $list);
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
        // 查询角色信息
        $role = Db::name('role')->where('id', $id)->find();

        // 查所有节点
        $date = Db::view('lamp_node', 'id,name')->select();
        // 查询该角色的节点
        $list = Db::view('lamp_role_node', 'nid')
            ->view('lamp_node', "id,name,mname,aname", 'lamp_node.id=lamp_role_node.nid')
            ->where('rid', '=', $id)
            ->select();
        if(!empty($list)){

            foreach ($list as $v) {
                $lists[] = $v['nid'];
            }
            $this->assign('lists', $lists);
        }else{
            $this->assign('lists',['99999']);
        }

        $this->assign('role', $role);
        $this->assign('date', $date);
        return view('role/nodelist');
    }

    public function rolenode(Request $request)
    {

        $list = $request->post();
        $id = $list['id'];
        if(empty($list['node'])){return $this->success('必须添加节点', url('admin/role/nodelist',['id'=>$id]));}
        $node = $list['node'];

        Db::startTrans();
        try {
            db('role_node')->where('rid', $id)->delete();
            foreach ($node as $v) {
                $date['nid'] = $v;
                $date['rid'] = $id;
                $result = db('role_node')->insert($date);
            }
// 提交事务
            Db::commit();
        } catch (\Exception $e) {
// 回滚事务
            Db::rollback();
        }
        if ($result) {
            return $this->success('更新(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/role/index'));
        } else {
            return $this->success('更新失败(o＞ω＜o)雅蠛蝶');
        }


    }

    public function delete($id)
    {
        $result = db('role')->where('id', $id)->delete();
        if ($result > 0) {
            return $this->success('删除(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/role/index'));
        } else {
            return $this->success('删除(o＞ω＜o)雅蠛蝶');
        }
    }

    public function edit($id)
    {
        $list = db('role')->field(['id', 'name', 'remark', 'status'])->where('id', $id)->select();

        $this->assign('list', $list['0']);
        return view('role/update');
    }



    public function update(Request $request, $id)
    {
        $list = $request->put();

        $date = [
            'name' => $list['name'],
            'remark' => $list['remark'],

            'status' => $list['status']
        ];

        $result = db('role')->where('id', $id)->update($date);
        if ($result > 0) {
            return $this->success('更新成功(((((((((((っ･ω･)っ Σ(σ｀･ω･´)σ 起飞！', url('admin/role/index'));
        } else {
            return $this->success('更新失败(o＞ω＜o)雅蠛蝶');
        }
    }


}
