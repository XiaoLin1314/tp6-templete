<?php
declare (strict_types=1);

namespace app\backend\controller\v1;

use app\common\model\BackendPermission;
use app\common\model\BackendMember as BackendMemerModel;
use think\facade\Cache;

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
        // 获取用户角色信息
        $userRole = BackendMemerModel::where(['id' => $this->user_id])->field('id,role_id')
            ->with(['role', 'role_permission'])
            ->withAttr('role_permission.permission_id', function ($val, $data) {
                return BackendPermission::where(['id' => $val])->field('id,title,action,status,pid')->find();
            })
            ->find();
        // 定义权限新数组
        $role_permission_list = [];
        foreach ($userRole->role_permission as $k => $v) {
            $role_permission_list[$k]['id'] = $v->permission_id->id;
            $role_permission_list[$k]['title'] = $v->permission_id->title;
            $role_permission_list[$k]['action'] = $v->permission_id->action;
            $role_permission_list[$k]['status'] = $v->permission_id->status;
            $role_permission_list[$k]['pid'] = $v->permission_id->pid;
        }
        // 获取权限树，默认缓存2个小时
        $cache_role_permission_list = Cache::get('backend_' . $this->user_id . ':role_permission');
        if (!$cache_role_permission_list) {
            // 通过方法获取权限树
            $cache_role_permission_list = $role_permission_list = getTree($role_permission_list);
            Cache::set('backend_' . $this->user_id . ':role_permission', $role_permission_list, 7200);
        }
        // 删除重复、不使用数据
        unset($userRole['role_permission']);
        // 返回数据
        return sucessMsg(200, '获取成功！', ['userRole' => $userRole, 'permissions' => $cache_role_permission_list]);
    }

    /***
     * 清除缓存
     */
    public function clearCache()
    {
        Cache::clear();
    }
}
