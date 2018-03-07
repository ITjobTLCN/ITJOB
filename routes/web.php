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
Route::get('/',[
	'as'=>'/',
	'uses'=>'PageController@getIndex'
]);
//contact
Route::get('lien-he',[
	'as'=>'contact',
	'uses'=>'PageController@getContact'
]);
Route::post('lien-he',[
	'as' => 'contact',
	'uses' => 'PageController@postContact'
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
Route::group(['prefix'=>'users', 'middleware'=>'auth'],function() {
	Route::get('profile',['as'=>'profile','uses'=>'UsersController@getProfile']);
	Route::post('profile',['as'=>'postAvatar','uses'=>'UsersController@postAvatar']);
	Route::post('edit-email',['as'=>'editEmail', 'uses'=>'UsersController@editEmail']);
	Route::post('editProfile',['as'=>'editProfile', 'uses'=>'UsersController@editProfile']);
	Route::get('job-applications',['as'=>'jobApplications','uses'=>'UsersController@getJobApplicationsOfUser']);
});

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
Route::group(['prefix' => 'companies'],function(){
	Route::get('',['as' => 'companies','uses' => 'CompanyController@getIndex']);
	Route::get('all-jobs-company',['as' => 'AllJobCompany','uses' => 'CompanyController@getListJobCompany']);
	Route::get('list-skill',['as' => 'listskill','uses'=>'PageController@getAllSkills']);
	Route::get('get-more-job',['as' => 'get-more-job','uses' => 'CompanyController@getMoreJob']);
	
	Route::get('search-companies',['as' => 'searchCompanies','uses' => 'CompanyController@getCompaniesReview']);
	Route::get('search-companies-by-name',['as' => 'searchCompaniesbyname','uses' => 'CompanyController@searchCompaniesByName']);
	//click to follow conpany
	Route::get('follow-company',['as' => 'followCompany','uses' => 'CompanyController@followCompany']);
	
	//submit review companies
	Route::post('review',['as' => 'submitReviewCompany','uses' => 'CompanyController@postReviewCompanies']);
	//get details company
	Route::get('{alias}',['as' => 'getEmployers','uses' => 'CompanyController@getDetailsCompanies']);
	//review
	Route::get('{alias}/review',['as' => 'reviewCompany','uses' => 'CompanyController@getReviewCompanies'])->middleware('auth');
	Route::post('{alias}/review',['as' => 'reviewCompany','uses' => 'CompanyController@postReviewCompanies'])->middleware('auth');
});
//get more companies
Route::group(['prefix' => 'more-companies'],function(){
	Route::get('', ['as' => 'more-companies', 'uses' => 'CompanyController@getMoreCompanies']);
	Route::get('hiring', ['as' => 'more-hiring-companies', 'uses' => 'CompanyController@getMoreHirring']);
	Route::get('most-followed', ['as' => 'more-hiring-companies', 'uses' => 'CompanyController@getMoreMostFollowed']);
});
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
	Route::get('all-jobs',['as'=>'alljobs','uses'=>'JobsController@getIndex']);
	Route::get('work-at-{city}',['as'=>'seachjobByCity','uses'=>'JobsController@getListJobByCity']);
	Route::get('{alias}',['as'=>'seachjob1opt','uses'=>'JobsController@getListJobBySkill']);

	Route::get('{alias}/at-{city}',['as'=>'seachjob','uses'=>'JobsController@getListJobSearch']);
	Route::get('{alias}/{id}',['as'=>'detailjob','uses'=>'JobsController@getDetailsJob']);
	Route::get('{alias}-{employer}/{id}/apply',['as'=>'getApplyJob','uses'=>'JobsController@getApplyJob']);
});
Route::post('apply-job',['as'=>'applyJob','uses'=>'JobsController@applyJob']);
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

Route::post('register-modal',[
	'as'=>'registerModal',
	'uses'=>'UsersController@postRegisterModal'
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
//get list skills of employer by emp_id
Route::get('list-skill-emp',[
	'as'=>'getListSkillEmployer',
	'uses'=>'CompanyController@getListSkillEmployer'
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
Route::post('login-modal',[
	'as'=>'loginModal',
	'uses'=>'UsersController@postLoginModal'
]);

Route::get('logout',['as'=>'getlogout','uses'=>'HomeController@getLogOut']);

Route::post('nglogin',['as'=>'ngpostlogin','uses'=>'HomeController@ngPostLogin']);

Route::get('ngloadreg',['as'=>'ngloadreg','uses'=>'HomeController@ngLoadReg']);
Route::get('registeremp',['as'=>'getregisteremp','uses'=>'HomeController@getRegisterEmp'])->middleware('auth');
Route::post('registeremp',['as'=>'postregisteremp','uses'=>'HomeController@postRegisterEmp'])->middleware('auth');

	/**--------------ADMIN ROUTE--------------------*/
Route::group(['prefix'=>'admin','middleware'=>'admin'],function(){
	Route::get('users',['as'=>'getadminusers','uses'=>'AdminController@getListUsers']);
	Route::get('emps',['as'=>'getadminemps','uses'=>'AdminController@getListEmps']);
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

		/*admin employers  --- output: json*/
	Route::get('ngemps',['as'=>'nggetemps','uses'=>'AdminController@ngGetEmps']);
	Route::get('ngemp/{id}',['as'=>'nggetemp','uses'=>'AdminController@ngGetEmp']);
	Route::post('ngcreateemp',['as'=>'ngpostcreateemp','uses'=>'AdminController@ngPostCreateEmp']);
	Route::post('ngeditemp/{id}',['as'=>'ngposteditemp','uses'=>'AdminController@ngPostEditEmp']);
	Route::get('ngdeleteemp/{id}',['as'=>'nggetdeleteemp','uses'=>'AdminController@ngGetDeleteEmp']);
	Route::get('ngconfirmemp/{id}',['as'=>'nggetconfirmemp','uses'=>'AdminController@ngGetConfirmEmp']);
	Route::get('ngdenyemp/{id}',['as'=>'nggetdenyemp','uses'=>'AdminController@ngGetDenyEmp']);

		//Send notification
	Route::get('notification','AdminController@getAdminNotification')->name('getadminnotification');
	Route::post('createnotification','AdminController@createNotification')->name('createnotification');

});

	/**--------------EMPLOYER ROUTE--------------------*/
Route::group(['prefix'=>'emp','middleware'=>'emp'],function(){
	/*Employer Advance*/
	Route::get('/',['as'=>'getemp','uses'=>'EmpController@getIndex']);
	Route::get('advance',['as'=>'getempadvance','uses'=>'EmpController@getAdvance']);

		/*employer manage  --- output: json*/
	Route::get('ngadvance/{id}',['as'=>'nggetadvance','uses'=>'EmpController@ngGetAdvance']);
	Route::get('ngconfirmass/{id}/{user_id}',['as'=>'nggetconfirmass','uses'=>'EmpController@ngGetConfirmAss']);
	Route::get('ngdenyass/{id}/{user_id}',['as'=>'nggetdenyass','uses'=>'EmpController@ngGetDenyAss']);
		/*Update info*/
	Route::post('ngupdateinfo/{id}',['as'=>'ngupdateempinfo','uses'=>'EmpController@ngGetUpdateEmpInfo']);
		/*Change logo-cover using Laravel - Reload page*/
	Route::post('changelogocover/{empid}/{type}',['as'=>'postChangeLogoCover','uses'=>'EmpController@postChangeLogoCoverEmp']);

		/*Employer Basic*/
	Route::get('basic',['as'=>'getempbasic','uses'=>'EmpController@getBasic']);
	Route::get('ngbasic/{id}',['as'=>'nggetbasic','uses'=>'EmpController@ngGetBasic']);
	Route::post('ngcreatepost/{empid}',['as'=>'ngcreatepost','uses'=>'EmpController@ngCreatePost']);
	Route::get('nggetpost/{id}',['as'=>'nggetpost','uses'=>'EmpController@ngGetPost']);
	Route::post('ngeditpost/{empid}/{id}',['as'=>'ngeditpost','uses'=>'EmpController@ngEditPost']);
	Route::get('ngtrashpost/{id}',['as'=>'ngtrashpost','uses'=>'EmpController@ngTrashPost']);
	Route::get('ngpushpost/{id}',['as'=>'ngpushpost','uses'=>'EmpController@ngPushPost']);
	Route::get('ngconfirmpost/{id}',['as'=>'ngconfirmpost','uses'=>'EmpController@ngConfirmPost']);
	Route::get('ngdenypost/{id}',['as'=>'ngdenypost','uses'=>'EmpController@ngDenyPost']);
});
	
	/*download aplication's CV*/
Route::get('downloadcv/{name}',['as'=>'getempdownloadcv','uses'=>'HomeController@getDownloadEmpCV']);

	/*send Email*/
Route::post('sendemail',['as'=>'postsendemail','uses'=>'EmpController@postSendEmail']);
Route::get('/markAsRead',function(){
	auth()->user()->unreadnotifications->markAsRead();
});
/*-----------------END DAT ROUTER----------------------*/
Route::get('/demo', [
	'as' => 'demo',
	'uses' => 'PageController@getDemo'
]);
