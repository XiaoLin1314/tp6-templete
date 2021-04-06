<?php
declare (strict_types=1);

namespace app\common\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class UserToken extends Model
{
    //  连接数据库
    protected $connection = 'bairui';
    //  连接表名
    protected $name = 'user_token';
    //  自动写入时间戳字段
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    // 查询用户token
    public static function fetchToken($user_id, $type = 'api')
    {
        return self::where(['user_id' => $user_id, 'type' => $type])->value('token');
    }

    // 新增token
    public function createToken($user_id, $token, $type = 'api')
    {
        // 检测是否存在，存在更新，不存在新增
        $info = $this->where(['user_id' => $user_id, 'type' => $type])->find();
        if (!empty($info)) {
            return $this->where('id', $info->id)->save([
                'user_id' => $user_id,
                'type' => $type,
                'token' => $token
            ]);
        } else {
            return $this->save([
                'user_id' => $user_id,
                'type' => $type,
                'token' => $token
            ]);
        }
    }
}
