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

Route::get('/', function () {
    return view('welcome');
    
});



// Auth::routes();

Route::get('php/login.php', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('php/login.php', 'Auth\LoginController@login');
Route::post('php/logout.php', 'Auth\LoginController@logout')->name('logout');

Route::get('member_regist.php', 'Auth\RegisterController@showRegistrationForm')->name('user.register_show');
Route::post('member_regist.php', 'Auth\RegisterController@post')->name('user.register_post');
Route::get('member_regist.php/confirm', 'Auth\RegisterController@confirm')->name('user.register_confirm');
Route::post('member_regist.php/confirm', 'Auth\RegisterController@register')->name('user.register_register');
Route::get('member_regist.php/complete', 'Auth\RegisterController@complete')->name('user.register_complete');


Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');



Route::get('/home', 'HomeController@index')->name('home');



Route::get('php/thread.php/search', 'PostController@search')->name('posts.search');
Route::group(['middleware' => 'auth'], function() {
    Route::get('php/thread_regist.php', 'PostController@create')->name('posts.create');
    Route::post('php/thread_regist.php/confirm', 'PostController@confirm')->name('posts.confirm');
	Route::post('posts/{comment}/favorites', 'BookmarkController@store')->name('favorites');
    Route::post('posts/{comment}/unfavorites', 'BookmarkController@destroy')->name('unfavorites');

});
// ??????
Route::get('php/thread.php', 'PostController@index')->name('posts.index');
// ??????
Route::post('php/thread.php', 'PostController@store')->name('posts.store');
// ??????
Route::get('php/thread_detail.php/{post_id}', 'PostController@show')->name('posts.show');
// ??????
Route::get('php/thread.php/edit/{post_id}', 'PostController@edit')->name('posts.edit');
// ??????
Route::put('php/thread.php/{post_id}', 'PostController@update')->name('posts.update');
// ??????
Route::delete('php/thread.php/{post_id}', 'PostController@destroy')->name('posts.destroy');


Route::resource('comments', 'CommentController');





Route::resource('users','UsersController',['only'=>['destroy']]);
Route::get('php/member_withdrawal.php','UsersController@delete_confirm')->name('users.delete_confirm');


//?????????
Route::group(['middleware' => ['auth.admin']], function () {
	
	//??????????????????
	Route::get('php/admin.php', 'admin\AdminTopController@show')->name('admin.top');
	//?????????????????????
	Route::post('php/admin/logout.php', 'admin\AdminLogoutController@logout');
	//??????????????????
	Route::get('php/admin/member.php', 'admin\ManageUserController@showUserList')->name('users.userlist');
    //??????????????????
	Route::get('php/admin/member.php/search', 'admin\ManageUserController@search')->name('users.search');
	//??????????????????
	Route::get('php/admin/member_detail.php/{id}', 'admin\ManageUserController@showUserDetail')->name('users.detail');
	//??????????????????
	Route::get('php/admin/member_edit.php/{id}', 'admin\ManageUserController@edit')->name('users.edit');
	Route::post('php/admin/member_edit.php', 'admin\ManageUserController@post')->name('users.post');
	//????????????????????????
	Route::get('php/admin/member_edit.php/confirm', 'admin\ManageUserController@editconfirm')->name('users.editconfirm');
	//????????????????????????
	Route::put('php/admin/member_edit.php/{id}', 'admin\ManageUserController@update')->name('users.update');
    //??????????????????
	Route::get('php/admin/member_regist.php', 'admin\ManageUserController@showRegistrationForm')->name('users.register_show');
	//????????????????????????
	Route::post('php/admin/member_regist.php', 'admin\ManageUserController@register')->name('users.register');
});

//?????????????????????
Route::get('php/admin/login.php', 'admin\AdminController@showLoginform')->name('admin.login');
Route::post('php/admin/login.php', 'admin\AdminController@login')->name('admin.logout');