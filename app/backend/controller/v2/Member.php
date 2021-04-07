<?php
declare (strict_types=1);

namespace app\backend\controller\v2;

use app\Common\model\Member as MemberModel;
use think\Request;

class Member extends BaseController
{
    /**
     * 会员列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 会员表
        $user = new MemberModel();
        // where条件
        $where = [];
        $status = input('get.status/d', 1);
        if (!empty($status)) {
            $where[] = ['status', '=', $status];
        }
        $account = input('get.account/s', '');
        if (!empty($account)) {
            $where[] = ['account', 'like', '%' . $status . '%'];
        }
        // 分页、排序等
        $page = input('page/d', 1);
        $pageSize = input('pageSize/d', 15);
        $sort = ['id' => 'desc', 'status' => 'desc'];
        $field = 'id,account,created_at';
        //获取列表
        $list = $user->fetchListByWhere($where, $sort, $field, $page, $pageSize);
        return sucessMsg(200, '会员获取成功！', ['list' => $list, 'total' => count($list)]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //新增会员
        $user = new MemberModel();
        $user->account = 'admin';
        $user->salt = getRandStr(6);
        $user->password_hash = makePassword('123123', $user->salt);
        if ($user->save()) {
            return sucessMsg(200, '创建成功！', $user->id);
        }
        return errMsg(500, '创建失败！');
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $id = input('id/d');
        if (empty($id)) {
            return errMsg(400, '请选择会员！');
        }
        $user = MemberModel::find($id);
        $user->account = 'admin';
        $user->salt = getRandStr(6);
        $user->password_hash = makePassword('123123', $user->salt);
        if ($user->save()) {
            return sucessMsg(200, '修改成功！', $user->id);
        }
        return errMsg(500, '修改失败！');
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $id = input('id/d', 0);
        if (empty($id)) {
            return errMsg(400, '请选择要删除用户id！');
        }
        if (MemberModel::destroy($id)) {
            return sucessMsg(200, '删除成功！');
        }
        return errMsg(500, '删除失败！');
    }
}
