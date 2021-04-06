<?php
declare (strict_types=1);

namespace app\api\validate;

use think\Validate;

class LoginValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'account' => 'require|max:25|min:4',
        'password' => 'require|max:50|min:6',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'account.require' => '请输入账号！',
        'account.max' => '账号不能超过25位！',
        'account.min' => '账号最少4位！',
        'password.require' => '请输入密码！',
        'password.max' => '密码不能超过25位！',
        'password.min' => '密码最少6位！',
    ];

    /**
     * 验证场景
     */
    protected $scene = [
        'login' => ['account', 'password'],
        'register' => ['account', 'password']
    ];
}
