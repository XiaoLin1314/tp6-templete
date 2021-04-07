<?php

use think\facade\Route;
use think\facade\Request;

$version = Request::header('version', 'v1');#接口版本
Route::group('', function () use ($version) {
    // 登录
    Route::group('site', function () use ($version) {
        Route::post('login', "backend/{$version}.Site/login");
    });

    // 后台用户管理
    Route::group('backendMember', function () use ($version) {
        Route::get(':id', "backend/{$version}.BackendMember/index");
        //  获取后台角色信息
        Route::get('get-role', "backend/{$version}.BackendMember/getrole");
        //  清除缓存
        Route::get('clear-cache', "backend/{$version}.BackendMember/clearcache");
    })->middleware('checkLogin');

    // 会员管理
    Route::group('member', function () use ($version) {
        Route::get('index', "backend/{$version}.Member/index");
        Route::post('create', "backend/{$version}.Member/create");
        Route::put('update', "backend/{$version}.Member/update");
        Route::delete('delete', "backend/{$version}.Member/delete");
    })->middleware('checkLogin');

})->allowCrossDomain([
    'Access-Control-Allow-Origin' => '*',
    'Access-Control-Allow-Methods' => 'GET,POST',
    'Access-Control-Allow-Headers' => 'content-type,token,version',
    'Access-Control-Allow-Credentials' => 'true'
]);