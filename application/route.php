<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//
Route::resource('/','index/index/index');
Route::post('admin','admin/index/logindo');
Route::get('admin','admin/index/index');
Route::get('logout','admin/index/logout');
Route::get('role/rolelist/:id','admin/user/rolelist');
Route::get('role/nodelist/:id','admin/role/nodelist');

Route::get('user/delete/:id','admin/user/delete');
Route::get('role/delete/:id','admin/role/delete');
Route::get('node/delete/:id','admin/node/delete');


Route::resource('user', 'admin/user');
Route::resource('role', 'admin/role');
Route::resource('node', 'admin/node');

Route::get(':name$', 'admin/main/index');
return [

];
