<?php
declare (strict_types = 1);

namespace app\common\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Member extends Model
{
    //  连接数据库
    protected $connection = 'bairui';
    //  连接表名
    protected $name = 'member';
    //  自动写入时间戳字段
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    //  根据id获取用户信息
    public function fetchInfoById($id, $field = '*')
    {
        return $this->field($field)->find($id);
    }

    //  根据where条件查询用户信息
    public function fetchInfoByWhere($where, $field = ['*'])
    {
        return $this->where($where)->field($field)->find();
    }

    // 分页查询,获取列表
    public function fetchListByWhere($where, $order = ['id' => 'desc'], $field = '*', $page = 1, $pageSize = 10)
    {
        return $this->field($field)->where($where)->order($order)->page($page, $pageSize)->select()->toArray();
    }

    // 关联 article
    public function Art(){
        return $this->hasOne(Article::class, 'user_id','id');
    }
}
