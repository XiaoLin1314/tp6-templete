<?php

use think\facade\Route;

// 登录
Route::group('site', function () {
    Route::post('login', 'site/login');
});

/**
 * 后台用户
 */
Route::group('backendMember', function () {
    Route::get(':id', 'backendMember/index');
    Route::get('get-role', 'backendMember/getrole');
})->middleware('checkLogin');

/**
 * 会员管理
*/
Route::group('member', function () {
    Route::get('index', 'Member/index');
    Route::post('create', 'Member/create');
    Route::put('update', 'Member/update');
    Route::delete('delete', 'Member/delete');
})->middleware('checkLogin');