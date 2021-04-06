<?php
declare (strict_types = 1);

namespace app\common\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Article extends Model
{
    //  连接数据库
    protected $connection = 'bairui';
    //  连接表名
    protected $name = 'article';
    //  自动写入时间戳字段
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
