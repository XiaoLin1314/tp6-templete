<?php

use think\facade\Route;
use think\facade\Request;

$version = Request::header('version', 'v1');#接口版本
Route::group('', function () use ($version) {
    /**
     * 登录
     * 注册
     */
    Route::group('site', function () use ($version) {
        Route::post('login', "api/{$version}.Site/login");
        Route::post('reg', "api/{$version}.Site/register");
    });

    /**
     * 会员管理
     */
    Route::group('member', function () use ($version) {
        Route::get('get-info', "api/{$version}.Member/getInfo");
    })->middleware('checkLogin');

})->allowCrossDomain([
    'Access-Control-Allow-Origin' => '*',
    'Access-Control-Allow-Methods' => 'GET,POST',
    'Access-Control-Allow-Headers' => 'content-type,token,version',
    'Access-Control-Allow-Credentials' => 'true'
]);