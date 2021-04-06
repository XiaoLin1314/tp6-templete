<?php

use think\facade\Route;

/**
 * 登录
 * 注册
 * 忘记密码
 */
Route::group('site', function () {
    Route::post('login', 'site/login');
    Route::post('reg', 'site/register');
});

/**
 * 会员管理
 */
Route::group('member', function () {
    Route::get('get-info', 'member/getInfo');
})->middleware('checkLogin');