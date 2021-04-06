<?php
declare (strict_types=1);

namespace app\api\middleware;

class checkLogin
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $token = $request->header('token');
        $res = checkToken($token);
        if ($res['code'] == -1) {
            return errMsg(400, $res['msg']);
        }
        if ($res['data']->login_type != 'api'){
            return errMsg(403, '禁止访问');
        }
        $request->user_id = $res['data']->uid;
        return $next($request);
    }

}
