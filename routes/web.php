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
//list cities
Route::get('list-city',[
	'as'=>'listcity',
	'uses'=>'PageController@getAllCities'
]);
//list skills
Route::get('list-skill',[
	'as'=>'listskill',
	'uses'=>'PageController@getAllSkills'
]);
//search company default
Route::get('search-companies',[
	'as'=>'search-companies',
	'uses'=>'CompanyController@searchCompany'
]);
//get employers by id
Route::group(['prefix'=>'companies'],function(){
	Route::get('',['as'=>'companies','uses'=>'CompanyController@getIndex']);
	Route::get('all-jobs-company',['as'=>'AllJobCompany','uses'=>'CompanyController@getListJobCompany']);
	Route::get('list-skill',['as'=>'listskill','uses'=>'PageController@getAllSkills']);
	Route::get('get-more-job',['as'=>'get-more-job','uses'=>'CompanyController@getMoreJob']);
	
	Route::get('search-companies',['as'=>'searchCompanies','uses'=>'CompanyController@getCompaniesReview']);
	Route::get('search-companies-by-name',['as'=>'searchCompaniesbyname','uses'=>'CompanyController@searchCompaniesByName']);	
	//count follow of companies
	Route::get('count-follow-com',['as'=>'countFollowCompany','uses'=>'CompanyController@countFollowCompany']);
	//click to follow conpany
	Route::get('follow-company',['as'=>'followCompany','uses'=>'CompanyController@followCompany']);
	//get details company
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
//get skills by job_id
Route::get('skill-by-job-id',[
	'as'=>'skill-by-job-id',
	'uses'=>'JobsController@getSkillByJobId'
]);
//jobs
Route::group(['prefix'=>'it-job'],function(){
	Route::get('tat-ca-viec-lam',['as'=>'alljobs','uses'=>'JobsController@getIndex']);
	Route::get('viec-lam-o-{city}',['as'=>'seachjobByCity','uses'=>'JobsController@getListJobByCity']);
	Route::get('{alias}',['as'=>'seachjob1opt','uses'=>'JobsController@getListJobBySkill']);

	Route::get('{alias}/tai-{city}',['as'=>'seachjob','uses'=>'JobsController@getListJobSearch']);
	Route::get('{alias}/{id}',['as'=>'detailjob','uses'=>'JobsController@getDetailsJob']);
});
Route::get('follow-job',['as'=>'follow-job','uses'=>'JobsController@followJob']);
//search job by name and city
Route::get('list-job-search',[
	'as'=>'list-job-search',
	'uses'=>'JobsController@getJobsBySearch'
]);
//get current user
Route::get('get-current-user',[
	'as'=>'get-current-user',
	'uses'=>'UsersController@getCurrentUser'
]);
//get job followed of user
Route::get('check-job-followed',[
	'as'=>'check-job-followed',
	'uses'=>'JobsController@getJobFollowed'
]);




/*Dat - Login*/
	//login-Register-Loggout
Route::get('login',['as'=>'getlogin','uses'=>'HomeController@getLogin']);
Route::post('login',['as'=>'postlogin','uses'=>'HomeController@postLogin']);
Route::get('register',['as'=>'getregister','uses'=>'HomeController@getRegister']);
Route::post('register',['as'=>'postregister','uses'=>'HomeController@postRegister']);
/*END Dat - Login*/