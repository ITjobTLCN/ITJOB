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
//get jobs of company by ajax
Route::get('list-jobs-company',[
	'as'=>'list-jobs-company',
	'uses'=>'CompanyController@getJobsCompany'
]);
//get employers by id
Route::group(['prefix'=>'companies'],function(){
	Route::get('',['as'=>'companies','uses'=>'CompanyController@getIndex']);
	Route::get('all-jobs-company',['as'=>'AllJobCompany','uses'=>'CompanyController@getListJobCompany']);
	Route::get('list-skill',['as'=>'listskill','uses'=>'PageController@getAllSkills']);
	Route::get('get-more-job',['as'=>'get-more-job','uses'=>'CompanyController@getMoreJob']);
	
	Route::get('search-companies',['as'=>'searchCompanies','uses'=>'CompanyController@getCompaniesReview']);
	Route::get('search-companies-by-name',['as'=>'searchCompaniesbyname','uses'=>'CompanyController@searchCompaniesByName']);
	//click to follow conpany
	Route::get('follow-company',['as'=>'followCompany','uses'=>'CompanyController@followCompany']);
	
	//submit review companies
	Route::post('review',['as'=>'submitReviewCompany','uses'=>'CompanyController@postReviewCompanies']);
	//get details company
	Route::get('{alias}',['as'=>'getEmployers','uses'=>'CompanyController@getDetailsCompanies']);
	//review
	Route::get('{alias}/review',['as'=>'reviewCompany','uses'=>'CompanyController@getReviewCompanies'])->middleware('auth');
	Route::post('{alias}/review',['as'=>'reviewCompany','uses'=>'CompanyController@postReviewCompanies'])->middleware('auth');
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



//login with social
Route::get('login/{provider}',['as'=>'loginProvider','uses'=>'AuthController@redirectToProvider']);
Route::get('login/{provider}/callback', 'AuthController@handleProviderCallback');


Route::get('see-more-reviews',[
	'as'=>'seeMoreReview',
	'uses'=>'CompanyController@seeMoreReviews'
])->middleware('auth');
Route::get('/demo',function(){
	return view('layouts.demo');
});
//get list skills of job by job_id
Route::get('list-skill-jobs',[
	'as'=>'getListSkillJob',
	'uses'=>'JobsController@getListSkillJob'
]);

/**------------------DAT ROUTER-------------------------
*----------------CHANGE YOUR LIFE-----------------------
*/
	/*-----IMPORT-EXPORT DATABASE BY EXCEL--------------
	|---I'm using Laravel-Excel  on --------------------
	|----https://github.com/Maatwebsite/Laravel-Excel---
	*/
Route::get('/import',function(){
	return view('admin.import');
});
	
Route::get('login',['as'=>'getlogin',function(){
	return redirect()->route('login');
}]);
Route::get('logout',['as'=>'getlogout','uses'=>'HomeController@getLogOut']);

Route::post('nglogin',['as'=>'ngpostlogin','uses'=>'HomeController@ngPostLogin']);

	/**--------------ADMIN ROUTE--------------------*/
Route::group(['prefix'=>'admin','middleware'=>'admin'],function(){
	Route::get('users',['as'=>'getadminusers','uses'=>'AdminController@getListUsers']);
	Route::get('dashboard',['as'=>'getadmindashboard','uses'=>'AdminController@getDashBoard']);
	Route::post('import',['as'=>'postimport','uses'=>'AdminController@postImport']);
	Route::get('export/{type}',['as'=>'getexport','uses'=>'AdminController@getExport']);

		/*angular-using*/
	Route::get('ngusers',['as'=>'nggetusers','uses'=>'AdminController@ngGetUsers']);
	Route::get('nguser/{id}',['as'=>'nggetuser','uses'=>'AdminController@ngGetUser']);
	Route::get('ngroles',['as'=>'nggetroles','uses'=>'AdminController@ngGetRoles']);
	Route::post('ngcreateuser',['as'=>'ngpostcreateuser','uses'=>'AdminController@ngPostCreateUser']);
	Route::post('ngedituser/{id}',['as'=>'ngpostedituser','uses'=>'AdminController@ngPostEditUser']);
	Route::get('ngdeleteuser/{id}',['as'=>'nggetdeleteuser','uses'=>'AdminController@ngGetDeleteUser']);


	/*admin dashboard  --- output: json*/
	Route::get('ngnumber',['as'=>'nggetnumber','uses'=>'AdminController@ngGetNumber']);
});
	/**--------------END ADMIN ROUTE--------------------*/



/*-----------------END DAT ROUTER----------------------*/	
