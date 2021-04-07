<?php

use Firebase\JWT\JWT;

/**
 * curl_get请求
 * $url 请求地址
 */
function curlGet($url, $type = 1)
{
    $header = array(
        'Accept: application/json',
    );
    $curl = curl_init();
    // 设置请求头
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_TIMEOUT, 5000);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_URL, $url);
    if ($type == 1) {
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    }
    $res = curl_exec($curl);
    if ($res) {
        curl_close($curl);
        return $res;
    } else {
        $error = curl_errno($curl);
        curl_close($curl);
        return $error;
    }
}

/**
 * curl_post 请求
 * $url 请求链接
 * $postdata 请求数据
 * $type：1.array，2.json
 */
function curlPost($url, $postdata = [], $type = 1)
{
    $header = array(
        'Accept: application/json',
    );
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // 超时设置
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    // 超时设置，以毫秒为单位
    // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);

    // 设置请求头
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);
    if ($type == 1) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    } else {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postdata));
    }
    //执行命令
    $data = curl_exec($curl);

    // 显示错误信息
    if (curl_error($curl)) {
        curl_close($curl);
        return "Error: " . curl_error($curl);
    } else {
        // 打印返回的内容
        curl_close($curl);
        return json_decode($data, true);

    }
}

/**
 * 成功返回信息
 * status：状态码
 * msg：提示信息
 * data：返回数据
 */
function sucessMsg($status = 200, $msg = '获取成功！', $data = [])
{
    return json([
        'code' => $status,
        'msg' => $msg,
        'data' => $data
    ], 200);
}

/**
 * 失败返回信息
 * status：状态码
 * msg：错误信息
 * data：返回数据
 */
function errMsg($status = 500, $msg = '获取失败！', $data = [])
{
    return json([
        'code' => $status,
        'msg' => $msg,
        'data' => $data
    ], 200);
}

/**
 * 返回随机字符串
 * length：字符串长度
 */
function getRandStr($length = 6)
{
    //字符组合
    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($str) - 1;
    $randstr = '';
    for ($i = 0; $i < $length; $i++) {
        $num = mt_rand(0, $len);
        $randstr .= $str[$num];
    }
    return $randstr;
}

/**
 * 生成密码
 * $password：密码
 * $salt：加密盐
 */
function makePassword($password, $salt)
{
    return md5(md5($password) . $salt);
}

/**
 * 验证密码
 * $password：密码
 * $salt：加密盐
 * $password_hash：用户密码
 */
function checkPassword($password, $member)
{
    if (empty($password) || empty($member)) {
        return false;
    }
    $inputPassword = makePassword($password, $member->salt);
    if ($inputPassword !== $member->password_hash) {
        return false;
    }
    return true;
}

/**
 * 生成验签
 * $uid 用户id
 * $key 这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当于加密中常用的盐  salt
 */
function signToken($uid, $type = 'api', $key = '!@#$%*&')
{
    $token = array(
        "iss" => $key,        //签发者 可以为空
        "aud" => '',          //面象的用户，可以为空
        "iat" => time(),      //签发时间
        "nbf" => time(),    //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
        "exp" => time() + 7200, //token 过期时间
        "data" => [           //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
            'uid' => $uid,
            'login_type' => $type
        ]
    );
    $resToken = JWT::encode($token, $key, "HS256");  //根据参数生成了 token
    return $resToken;
}

/**
 * 验证token
 */
function checkToken($token, $key = '!@#$%*&')
{
    $status = array("code" => -1);
    try {
        JWT::$leeway = 60;//当前时间减去60，把时间留点余地
        $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
        $arr = (array)$decoded;
        $res['code'] = 0;
        $res['data'] = $arr['data'];
        return $res;

    } catch (\Firebase\JWT\SignatureInvalidException $e) { //签名不正确
        $status['msg'] = "签名不正确";
        return $status;
    } catch (\Firebase\JWT\BeforeValidException $e) { // 签名在某个时间点之后才能用
        $status['msg'] = "token未生效";
        return $status;
    } catch (\Firebase\JWT\ExpiredException $e) { // token过期
        $status['msg'] = "token失效";
        return $status;
    } catch (\Exception $e) { //其他错误
        $status['msg'] = "未知错误";
        return $status;
    }
}

/**
 * 获取树结构
 * $arr 必须为数组
 * $pid 父id（上级id），默认为0
 */
function getTree($arr, $pid = 0)
{
    // 检验必须为数组
    if (!is_array($arr)) {
        return false;
    }
    $tree = [];
    foreach ($arr as $k => $v) {
        if ($v['pid'] == $pid) {
            $tree[$k] = $v;
            $tree[$k]['child'] = getTree($arr, $v['id']);
        }
        unset($arr[$k]);
    }
    return $tree;
}