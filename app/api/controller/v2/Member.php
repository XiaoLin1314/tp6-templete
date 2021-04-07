<?php
declare (strict_types=1);

namespace app\api\controller\v2;

use app\Common\model\Member as MemberModel;

class Member extends BaseController
{
    /**
     * 登录
     * 获取用户信息
     */
    public function getInfo()
    {
        // 获取登录用户id
        $user = new MemberModel();
        $userInfo = $user->where(['id' => $this->user_id])->with('art')->find();
        return sucessMsg(200, '获取成功！', $userInfo);
    }

}
