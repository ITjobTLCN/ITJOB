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
	'uses'=>'UsersController@getProfile'
]);
Route::get('profile-user',[
	'as'=>'profileuser',
	'uses'=>'UsersController@getProfileUser'
]);
//add
Route::post('add',[
	'as'=>'add',
	'uses'=>'UsersController@editEmail'
]);
//editProfile
Route::post('editProfile',[
	'as'=>'editProfile',
	'uses'=>'UsersController@editProfile'
]);
//list city
Route::get('list-city',[
	'as'=>'listcity',
	'uses'=>'PageController@getListCity'
]);
//list skills
Route::get('list-skill',[
	'as'=>'listskill',
	'uses'=>'PageController@getAllSkills'
]);
//search company
Route::get('search-company',[
	'as'=>'search-company',
	'uses'=>'CompanyController@searchCompany'
]);
//search company default

Route::get('search-company',[
	'as'=>'search-company',
	'uses'=>'CompanyController@searchCompany'
]);
//get employers by id
Route::group(['prefix'=>'companies'],function(){
	Route::get('/',['as'=>'companies','uses'=>'CompanyController@getIndex']);
	Route::get('/search-company',['as'=>'searchCompanies','uses'=>'CompanyController@getCompaniesReview']);
	Route::get('{alias}',['as'=>'getEmployers','uses'=>'CompanyController@getDetailsCompanies']);
});
//get more hiring companies
Route::get('more-hiring-companies',[
	'as'=>'more-hiring-companies',
	'uses'=>'CompanyController@getMoreHirring'
]);
//get mmore most followed companies
Route::get('more-most-followed-companies',[
	'as'=>'more-hiring-companies',
	'uses'=>'CompanyController@getMoreMostFollowed'
]);
//get attribute filter
Route::get('all-attribute-filter',[
	'as'=>'all-attribute-filter',
	'uses'=>'JobsController@getAttributeFilter'
]);
Route::get('filter-job',[
	'as'=>'filter-job',
	'uses'=>'JobsController@FilterJob'
]);
//search jobs
Route::get('search-job',[
	'as'=>'seach-job',
	'uses'=>'JobsController@getSearchJob'
]);
Route::get('demo',function(){
	return view('layouts.demo');
});
//load list job default
Route::get('list-job-lastest',[
	'as'=>'jobLastest',
	'uses'=>'JobsController@getListJobLastest'
]);
//get skills by job_id
Route::get('skill-by-job-id',[
	'as'=>'skill-by-job-id',
	'uses'=>'JobsController@getSkillByJobId'
]);
//jobs
Route::group(['prefix'=>'it-job'],function(){
	Route::get('/',['as'=>'alljobs','uses'=>'JobsController@getIndex']);
	Route::get('/search-job/{alias}',['as'=>'seachjob','uses'=>'JobsController@getListJobSearch']);
	Route::get('/{alias}-{id}',['as'=>'detailjob','uses'=>'JobsController@getDetailsJob']);
});


