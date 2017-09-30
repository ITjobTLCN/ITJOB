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
Route::get('/',function(){
	return view('layouts.trangchu');
});
Route::get('/',[
	'as'=>'/',
	'uses'=>'PageController@getIndex'
]);
//contact
Route::get('contact',[
	'as'=>'lienhe',
	'uses'=>'PageController@getContact'
]);
//companies
Route::get('companies',[
	'as'=>'companies',
	'uses'=>'PageController@getCompaniesReview'
	]);
//login
Route::get('dang-nhap',[
	'as'=>'login',
	'uses'=>'UsersController@getLogin'
]);
Route::post('dang-nhap',[
	'as'=>'login',
	'uses'=>'UsersController@postLogin'
]);
//register
Route::get('dang-ky',[
	'as'=>'register',
	'uses'=>'UsersController@getRegister'
]);
//admin
Route::group(['prefix'=>'admin','middleware'=>'admin'],function(){
	Route::get('index',['as'=>'admin-index','uses'=>'AdminController@getIndex']);
	Route::get('user',['as'=>'admin-user','uses'=>'AdminController@getUser']);
	Route::get('listUser',['as'=>'admin-listuser','uses'=>'AdminController@getListUser']);
	Route::post('addUser',['as'=>'admin-adduser','uses' =>'AdminController@postAddUser']);
	Route::get('getUser/{id}',['as'=>'admin-getuserid','uses' =>'AdminController@getUserId']);
	Route::post('editUser/{id}',['as'=>'admin-edituserid','uses' =>'AdminController@postEditUser']);
	Route::get('delUser/{id}',['as'=>'admin-deluserid','uses' =>'AdminController@getDelUser']);
});
//logout
Route::get('dang-xuat',[
	'as'=>'logout',
	'uses'=>'UsersController@logout'
]);
//profile candidate
Route::get('profile',[
	'as'=>'profile',
	'uses'=>'PageController@getProfile'
]);
//add
Route::post('add',[
	'as'=>'add',
	'uses'=>'PageController@editEmail'
]);
//editProfile
Route::post('editProfile',[
	'as'=>'editProfile',
	'uses'=>'PageController@editProfile'
]);


