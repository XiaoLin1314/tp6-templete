<?php
declare (strict_types=1);

namespace app\backend\controller\v2;

use app\api\validate\LoginValidate;
use app\common\model\UserToken;
use think\exception\ValidateException;
use app\common\model\BackendMember as BackendMember;

class Site
{
    /**
     * 登录
     * account：账号
     * password：密码
     */
    public function login()
    {
        $postData = input('post.');
        try {
            //  验证参数
            validate(LoginValidate::class)->scene('login')->check($postData);
            $user = new BackendMember();
            // 检测用户是否存在
            $memberInfo = $user->fetchInfoByWhere(['account' => $postData['account']], 'id,account,salt,password_hash');
            if (empty($memberInfo)) {
                return errMsg(422, '账号不存在！');
            }
            // 验证密码
            if (!checkPassword($postData['password'], $memberInfo)) {
                return errMsg(422, '密码错误！');
            }
            // 查询token，检测是否有效
            $userToken = UserToken::fetchToken($memberInfo->id, 'backend');
            if (empty($userToken)) {
                $userToken = signToken($memberInfo->id, 'backend');
                $tokenModel = new UserToken();
                if (!$tokenModel->createToken($memberInfo->id, $userToken, 'backend')) {
                    return errMsg(500, '系统错误，请联系管理员！');
                }
            } else {
                $resToken = checkToken($userToken);
                if ($resToken['code'] == -1) {
                    $tokenModel = new UserToken();
                    $userToken = signToken($memberInfo->id, 'backend');
                    if (!$tokenModel->createToken($memberInfo->id, $userToken, 'backend')) {
                        return errMsg(500, '系统错误，请联系管理员！');
                    }
                }
            }
            // 返回用户数据
            $resMember = [
                'id' => $memberInfo->id,
                'account' => $memberInfo->account,
                'token' => $userToken
            ];
            return sucessMsg(200, '登录成功', $resMember);
        } catch (ValidateException $e) {
            return errMsg(400, $e->getError());
        }
    }

    /**
     * 注册
     * account：账号
     * password：mima
     */
    public function register()
    {
        $postData = input('post.');
        try {
            //  验证参数
            validate(LoginValidate::class)->scene('register')->check($postData);
            $user = new BackendMember();
            $memberInfo = $user->fetchInfoByWhere(['account' => $postData['account']], 'id,account');
            if (!empty($memberInfo)) {
                return errMsg(422, '账号已存在！');
            }
            $postData['salt'] = getRandStr(6);
            $postData['password_hash'] = makePassword($postData['password'], $postData['salt']);
            if ($user->save($postData)) {
                return sucessMsg(200, '注册成功');
            }
            return errMsg(422, '注册失败，请重试！');
        } catch (ValidateException $e) {
            return errMsg(400, $e->getError());
        }
    }
}
