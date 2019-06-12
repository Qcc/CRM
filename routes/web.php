<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@root')->name('root');

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// 修改密码
Route::post('system/user/password/{users}', 'UsersController@password')->name('user.password');


//目标客户
Route::get('company/secrch', 'CompanysController@secrch')->name('company.secrch');
Route::get('company/upload', 'CompanysController@upload')->name('company.upload');
Route::post('company/store', 'CompanysController@store')->name('company.store');
Route::post('company/locking', 'CompanysController@locking')->name('company.locking');
// 今日目标 客户跟进
Route::get('company/follow', 'CompanysController@follow')->name('company.follow');
Route::get('company/follow/{company}', 'CompanysController@show')->name('company.show');
// 保存反馈
Route::post('record/store', 'RecordsController@store')->name('record.store');
// 客户跟进页面
Route::get('follow/follow', 'FollowsController@follow')->name('follow.follow');
Route::get('follow/follow/{follow}', 'FollowsController@show')->name('follow.show');
Route::post('follow/store/{follow}', 'FollowsController@store')->name('follow.store');
Route::post('follow/delay/{follow}', 'FollowsController@delay')->name('follow.delay');
Route::post('follow/storeRecord', 'FollowsController@storeRecord')->name('follow.storeRecord');
Route::post('follow/agent', 'FollowsController@agent')->name('follow.agent');
// 正式客户 合同上传
Route::post('customers/store', 'CustomersController@store')->name('customers.store');

// 正式客户资料
Route::get('customers/show', 'CustomersController@show')->name('customers.show');
Route::post('customers/check', 'CustomersController@check')->name('customers.check');
Route::post('customers/update', 'CustomersController@update')->name('customers.update');
Route::post('customers/destroy', 'CustomersController@destroy')->name('customers.destroy');
Route::post('customers/restore', 'CustomersController@restore')->name('customers.restore');


Route::group(['middleware' => ['permission:manager']], function () {
    // 基础资料设置
    Route::get('user/settings', 'UsersController@settings')->name('user.settings');
    Route::get('system/users', 'UsersController@users')->name('system.users');
    Route::post('system/user/update', 'UsersController@update')->name('user.update');
    Route::post('system/user/store', 'UsersController@store')->name('user.store');
    // 销售话术
    Route::get('speechs/index', 'SpeechsController@index')->name('speechs.index');
    Route::post('speech/store', 'SpeechsController@store')->name('speech.store');
    Route::post('speech/update', 'SpeechsController@update')->name('speech.update');
    Route::post('speech/destroy', 'SpeechsController@destroy')->name('speech.destroy');
    // 通用设置
    Route::get('system/show', 'PagesController@show')->name('settings.show');
    Route::post('system/store', 'PagesController@store')->name('settings.store');
    Route::post('system/report/send', 'PagesController@sendReport')->name('report.send');
    // 日志
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
