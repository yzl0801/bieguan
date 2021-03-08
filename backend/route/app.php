<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::post('login', 'auth/login')->name('login');

Route::group(function() {
    Route::get('config/get', 'config/get');
    Route::post('config/save', 'config/save');

    Route::get('member/list', 'member/lists');
    Route::get('member/profile', 'member/profile');
    Route::post('member/create', 'member/create');
    Route::post('member/update', 'member/update');
    Route::post('member/delete', 'member/delete');

    Route::post('member/account-change', 'member/accountChange');
    Route::get('member/balance-log-list', 'member/logs');
})->middleware('jwt-auth');


