<?php
declare (strict_types=1);

namespace app\backend\controller;

use app\common\model\BackendPermission;
use app\common\model\BackendRolePermission;
use think\Request;
use app\common\model\BackendMember as BackendMemerModel;

class BackendMember extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $id = input('id/d', 0);
        return $id;
    }

    /**
     * 获取角色权限
     */
    public function getRole()
    {
        $userRole = BackendMemerModel::where(['id' => $this->user_id])->field('id,role_id')
            ->with(['role', 'role_permission'])
            ->withAttr('role_permission.permission_id', function ($val, $data) {
                return BackendPermission::where(['id' => $val])->field('id,title,action,status,pid')->find();
            })
            ->find();
        $role_permission_list = [];
        foreach ($userRole->role_permission as $k => $v) {
            $role_permission_list[$k]['id'] = $v->permission_id->id;
            $role_permission_list[$k]['title'] = $v->permission_id->title;
            $role_permission_list[$k]['action'] = $v->permission_id->action;
            $role_permission_list[$k]['status'] = $v->permission_id->status;
            $role_permission_list[$k]['pid'] = $v->permission_id->pid;
        }
        $role_permission_list = $this->roleTree($role_permission_list);
        return sucessMsg(200, '获取成功！', ['1' => $userRole, '2' => $role_permission_list]);
    }

    public function roleTree($arr, $pid = 0)
    {
        $tree = [];
        foreach ($arr as $k => $v) {
            if ($v['pid'] == $pid) {
                $tree[$k] = $v;
                $tree[$k]['child'] = $this->roleTree($arr, $v['id']);
            }
        }
        dd($tree);

        return $tree;
    }
}
