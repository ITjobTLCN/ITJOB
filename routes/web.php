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
Route::get('/', [
	'as' => '/',
	'uses' => 'PageController@getIndex'
]);
//contact
Route::get('lien-he', [
	'as' => 'contact',
	'uses' => 'PageController@getContact'
]);
Route::post('lien-he', [
	'as' => 'contact',
	'uses' => 'PageController@postContact'
]);
//login
Route::get('dang-nhap', [
	'as' => 'login',
	'uses' => 'UsersController@getLogin'
]);
Route::post('dang-nhap', [
	'as' => 'login',
	'uses' => 'UsersController@postLogin'
]);
//register
Route::any('dang-ky', [
	'as' => 'register',
	'uses' => 'UsersController@register',
]);

//logout
Route::get('dang-xuat', [
	'as' => 'logout',
	'uses' => 'UsersController@logout'
]);
//profile candidate
Route::group([ 'prefix' => 'users', 'middleware' => 'auth'], function() {
	Route::get('profile', [ 'as' => 'profile', 'uses' => 'UsersController@getProfile' ]);
	Route::post('profile', [ 'as' => 'postAvatar', 'uses' => 'UsersController@postAvatar' ]);
	Route::post('edit-email', [ 'as' => 'editEmail', 'uses' => 'UsersController@editEmail' ]);
	Route::post('editProfile', [ 'as' => 'editProfile', 'uses' => 'UsersController@editProfile' ]);
	Route::get('job-applications', [ 'as' => 'jobApplications', 'uses' => 'UsersController@getJobApplicationsOfUser' ]);
});

//list cities
Route::get('list-city', [
	'as' => 'listCities',
	'uses' => 'PageController@getAllCities'
]);
//list skills
Route::get('list-skill', [
	'as' => 'listskill',
	'uses' => 'PageController@getAllSkills'
]);
//search company default
Route::get('search-companies', [
	'as' => 'search-companies',
	'uses' => 'CompanyController@searchCompany'
]);
//get jobs of company by ajax
// Route::get('list-jobs-company', [
// 	'as' => 'list-jobs-company',
// 	'uses' => 'CompanyController@getJaobsCompany'
// ]);
Route::get('more-jobs-company', [
	'as' => 'moreJobsCompany',
	'uses' => 'JobsController@getJobsCompany'
]);
Route::get('demo', [ 'as' => 'demo', 'uses' => 'CompanyController@getDemo' ]);
//get employers by id
Route::group([ 'prefix' => 'companies'], function() {
	Route::get('', [ 'as' => 'companies', 'uses' => 'CompanyController@getIndex' ]);
	Route::get('all-jobs-company', [ 'as' => 'AllJobCompany', 'uses' => 'CompanyController@getListJobCompany' ]);
	Route::get('list-skill', [ 'as' => 'listskill', 'uses' => 'PageController@getAllSkills' ]);
	Route::get('get-more-job', [ 'as' => 'get-more-job', 'uses' => 'CompanyController@getMoreJob' ]);
	Route::match([ 'get', 'post'], 'search-companies/{limit?}/{offset?}', [
		'as' => 'searchCompanies',
		'uses' => 'CompanyController@getCompaniesReview'
	]);
	Route::get('search-companies-by-name', [ 'as' => 'searchCompaniesByName', 'uses' => 'CompanyController@searchCompaniesByName' ]);
	//click to follow conpany
	Route::get('follow-company', [ 'as' => 'followCompany', 'uses' => 'CompanyController@followCompany' ]);
	//submit review companies
	Route::post('review', [ 'as' => 'submitReviewCompany', 'uses' => 'CompanyController@postReviewCompanies' ]);
	//get details company
	Route::get('{alias}', [ 'as' => 'getEmployers', 'uses' => 'CompanyController@getDetailsCompanies' ]);
	//review
	Route::get('{alias}/review', [ 'as' => 'reviewCompany', 'uses' => 'CompanyController@getReviewCompanies' ])->middleware('auth');
	Route::post('{alias}/review', [ 'as' => 'reviewCompany', 'uses' => 'CompanyController@postReviewCompanies' ])->middleware('auth');
});
//get more companies
Route::group([ 'prefix' => 'more-companies'], function() {
	Route::get('', [ 'as' => 'more-companies', 'uses' => 'CompanyController@getMoreCompanies' ]);
	Route::get('hiring', [ 'as' => 'more-hiring-companies', 'uses' => 'CompanyController@getMoreHirring' ]);
	Route::get('most-followed', [ 'as' => 'more-hiring-companies', 'uses' => 'CompanyController@getMoreMostFollowed' ]);
});
//get attribute filter
Route::get('all-attribute-filter', [
	'as' => 'all-attribute-filter',
	'uses' => 'JobsController@getAttributeFilter'
]);
Route::post('filter-job', [
	'as' => 'filter-job',
	'uses' => 'JobsController@filterJob'
]);
//search jobs
Route::get('search-job', [
	'as' => 'seach-job',
	'uses' => 'JobsController@getSearchJob'
]);
//get skills by job_id
Route::get('skill-by-job-id', [
	'as' => 'skill-by-job-id',
	'uses' => 'JobsController@getSkillByJobId'
]);
//jobs
Route::group([ 'prefix' => 'it-job'], function() {
	Route::get('/', ['as' => 'seachJob', 'uses' => 'JobsController@getListJobSearch' ]);
	Route::post('/', ['as' => 'seachJob', 'uses' => 'JobsController@postListJobSearch' ]);
	Route::get('all-jobs/{offset?}/{limit?}', [ 'as' => 'alljobs', 'uses' => 'JobsController@getIndex' ]);
	Route::get('work-at-{alias}', [ 'as' => 'seachJobByCity', 'uses' => 'JobsController@getListJobByCity' ]);
	Route::get('{jobAlias}/{cityAlias}', [ 'as' => 'seachJobFullOption', 'uses' => 'JobsController@getJobFullOption' ]);
	Route::get('{alias}', [ 'as' => 'quickJobBySkill', 'uses' => 'JobsController@getQuickJobBySkill' ])
		->where([ 'alias' => '[a-z]+' ]);
});

//get apply
Route::get('{alias}/{id}/apply', [ 'as' => 'getApplyJob', 'uses' => 'JobsController@getApplyJob' ])
	->where([ 'id' => '[0-9a-z]+' ]);

Route::get('detai-jobs/{alias}/{_id}', [
	'as' => 'detailjob',
	'uses' => 'JobsController@getDetailsJob'
]);
Route::post('apply-job', [ 'as' => 'applyJob', 'uses' => 'JobsController@applyJob' ]);
Route::post('follow-job', [ 'as' => 'follow-job', 'uses' => 'JobsController@followJob' ]);
//get job followed of user
Route::get('check-job-followed', [ 'as' => 'check-job-followed', 'uses' => 'JobsController@getJobFollowed' ]);

Route::post('register-modal', [ 'as' => 'registerModal', 'uses' => 'UsersController@postRegisterModal' ]);

//login with social
Route::get('login/{provider}', [ 'as' => 'loginProvider', 'uses' => 'AuthController@redirectToProvider' ]);
Route::get('login/{provider}/callback', 'AuthController@handleProviderCallback');

Route::get('see-more-reviews', [
	'as' => 'seeMoreReview',
	'uses' => 'CompanyController@seeMoreReviews'
])->middleware('auth');
Route::get('/demo', [
	'as' => 'demo',
	'uses' => 'CompanyController@getDemo'
]);
//get list skills of job by job_id
Route::get('list-skill-jobs', [
	'as' => 'getListSkillJob',
	'uses' => 'JobsController@getListSkillJob'
]);
//get list skills of employer by emp_id
Route::get('list-skill-emp', [ 'as' => 'getListSkillEmployer', 'uses' => 'CompanyController@getListSkillEmployer' ]);
//Clear Cache facade value:
Route::get('/cache/flushall', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('cache/flush/all', [
	'as' => 'clearAllCache',
	'uses' => 'PageController@clearAllCache'
]);
/**------------------DAT ROUTER-------------------------
*----------------CHANGE YOUR LIFE-----------------------
*/
	/*-----IMPORT-EXPORT DATABASE BY EXCEL--------------
	|---I'm using Laravel-Excel  on --------------------
	|----https://github.com/Maatwebsite/Laravel-Excel---
	*/
Route::get('/import', function() {
	return view('admin.import');
});
Route::get('login', [ 'as' => 'getlogin', function() {
	return redirect()->route('login');
}]);
Route::post('login-modal', [ 'as' => 'loginModal', 'uses' => 'UsersController@postLoginModal' ]);
Route::get('logout', [ 'as' => 'getlogout', 'uses' => 'HomeController@getLogOut' ]);
Route::post('nglogin', [ 'as' => 'ngpostlogin', 'uses' => 'HomeController@ngPostLogin' ]);
Route::get('ngload/register-employer', [ 'as' => 'loadRegisterEmployer', 'uses' => 'HomeController@loadRegisterEmployer' ]);
Route::get('register/employer', [
	'as' => 'getRegisterEmployer',
	'uses' => 'HomeController@getRegisterEmployer'
])->middleware('auth');
Route::post('register/employer', [
	'as' => 'postRegisterEmployer',
	'uses' => 'HomeController@postRegisterEmployer'
])->middleware('auth');
	/**--------------ADMIN ROUTE--------------------*/
Route::group([ 'prefix' => 'admin', 'middleware' => 'admin'], function() {
	Route::get('users', [ 'as' => 'getadminusers', 'uses' => 'AdminController@getListUsers' ]);
	Route::get('emps', [ 'as' => 'getadminemps', 'uses' => 'AdminController@getListEmps' ]);
	Route::get('dashboard', [ 'as' => 'getAdminDashboard', 'uses' => 'AdminController@getDashBoard' ]);
	Route::post('import', [ 'as' => 'postimport', 'uses' => 'AdminController@postImport' ]);
	Route::get('export/{type}', [ 'as' => 'getexport', 'uses' => 'AdminController@getExport' ]);

		/*angular-using*/
	Route::get('ngusers', [ 'as' => 'nggetusers', 'uses' => 'AdminController@ngGetUsers' ]);
	Route::get('nguser/{id}', [ 'as' => 'nggetuser', 'uses' => 'AdminController@ngGetUser' ]);
	Route::post('ngcreateuser', [ 'as' => 'ngpostcreateuser', 'uses' => 'AdminController@ngPostCreateUser' ]);
	Route::post('ngedituser/{id}', [ 'as' => 'ngpostedituser', 'uses' => 'AdminController@ngPostEditUser' ]);
	Route::get('ngdeleteuser/{id}', [ 'as' => 'nggetdeleteuser', 'uses' => 'AdminController@ngGetDeleteUser' ]);
		// Roles manage
	Route::get('ngroles', [ 'as' => 'nggetroles', 'uses' => 'AdminController@ngGetRoles' ]);
	Route::get('ngroles/{id}', [ 'as' => 'nggetroles', 'uses' => 'AdminController@ngGetRole' ]);
	Route::post('ngrole', [ 'as' => 'ng_add_roles', 'uses' => 'AdminController@ngAddRole' ]);
	Route::put('ngrole', [ 'as' => 'ng_edit_roles', 'uses' => 'AdminController@ngEditRole' ]);
	Route::delete('ngrole', [ 'as' => 'ng_delete_roles', 'uses' => 'AdminController@ngDeleteRole' ]);

		/*admin dashboard  --- output: json*/
	Route::get('ngnumber', [ 'as' => 'nggetnumber', 'uses' => 'AdminController@ngGetNumber' ]);

		/*admin employers  --- output: json*/
	Route::get('ngemps', [ 'as' => 'nggetemps', 'uses' => 'AdminController@ngGetEmps' ]);
	Route::get('ngemp/{id}', [ 'as' => 'nggetemp', 'uses' => 'AdminController@ngGetEmp' ]);
	Route::post('ngcreateemp', [ 'as' => 'ngpostcreateemp', 'uses' => 'AdminController@ngPostCreateEmp' ]);
	Route::post('ngeditemp/{id}', [ 'as' => 'ngposteditemp', 'uses' => 'AdminController@ngPostEditEmp' ]);
	Route::get('ngdeleteemp/{id}', [ 'as' => 'nggetdeleteemp', 'uses' => 'AdminController@ngGetDeleteEmp' ]);
	Route::get('ngconfirmemp/{id}', [ 'as' => 'nggetconfirmemp', 'uses' => 'AdminController@ngGetConfirmEmp' ]);
	Route::get('ngdenyemp/{id}', [ 'as' => 'nggetdenyemp', 'uses' => 'AdminController@ngGetDenyEmp' ]);

		//Send notification
	Route::get('notification', 'AdminController@getAdminNotification')->name('getadminnotification');
	Route::post('createnotification', 'AdminController@createNotification')->name('createnotification');

});
//Route::get('ngbasic/{id}', [ 'as' => 'ngGetBasic', 'uses' => 'EmployerController@ngGetBasic' ]);
//Route::get('ngadvance', [ 'as' => 'nggetadvance', 'uses' => 'EmployerController@ngGetAdvance' ]);
//Route::get('ng-confirm-ass', [ 'as' => 'ngConfirmAss', 'uses' => 'EmployerController@ngGetConfirmAss' ]);
	/**--------------EMPLOYER ROUTE--------------------*/
Route::group([ 'prefix' => 'emp', 'middleware' => 'emp'], function() {
	/*Employer Advance*/
	Route::get('/', [ 'as' => 'getEmp', 'uses' => 'EmployerController@getIndex' ]);
	Route::get('advance', [ 'as' => 'getEmpAdvance', 'uses' => 'EmployerController@getAdvance' ]);

		/*employer manage  --- output: json*/
	Route::get('ngadvance', [ 'as' => 'nggetadvance', 'uses' => 'EmployerController@ngGetAdvance' ]);
	Route::post('ng-confirm-ass', [ 'as' => 'ngConfirmAss', 'uses' => 'EmployerController@ngGetConfirmAss' ]);
	Route::get('ngdenyass/{id}/{user_id}', [ 'as' => 'nggetdenyass', 'uses' => 'EmployerController@ngGetDenyAss' ]);
		/*Update info*/
	Route::post('ngupdateinfo/{id}', [ 'as' => 'ngupdateempinfo', 'uses' => 'EmployerController@ngGetUpdateEmpInfo' ]);
		/*Change logo-cover using Laravel - Reload page*/
	Route::post('changelogocover/{empid}/{type}', [ 'as' => 'postChangeLogoCover', 'uses' => 'EmployerController@postChangeLogoCoverEmp' ]);

		/*Employer Basic*/
	Route::get('basic', [ 'as' => 'getEmpBasic', 'uses' => 'EmployerController@getEmpBasic' ]);
	Route::get('ngbasic', [ 'as' => 'ngGetBasic', 'uses' => 'EmployerController@ngGetBasic' ]);
	Route::post('ngcreatepost/{empid}', [ 'as' => 'ngcreatepost', 'uses' => 'EmployerController@ngCreatePost' ]);
	Route::get('nggetpost/{id}', [ 'as' => 'nggetpost', 'uses' => 'EmployerController@ngGetPost' ]);
	Route::post('ngeditpost/{empid}/{id}', [ 'as' => 'ngeditpost', 'uses' => 'EmployerController@ngEditPost' ]);
	Route::get('ngtrashpost/{id}', [ 'as' => 'ngtrashpost', 'uses' => 'EmployerController@ngTrashPost' ]);
	Route::get('ngpushpost/{id}', [ 'as' => 'ngpushpost', 'uses' => 'EmployerController@ngPushPost' ]);
	Route::get('ngconfirmpost/{id}', [ 'as' => 'ngconfirmpost', 'uses' => 'EmployerController@ngConfirmPost' ]);
	Route::get('ngdenypost/{id}', [ 'as' => 'ngdenypost', 'uses' => 'EmployerController@ngDenyPost' ]);
});
/*download aplication's CV*/
Route::get('downloadcv/{name}', [ 'as' => 'getempdownloadcv', 'uses' => 'HomeController@getDownloadEmpCV' ]);

	/*send Email*/
Route::post('sendemail', [ 'as' => 'postsendemail', 'uses' => 'EmployerController@postSendEmail' ]);
Route::get('/markAsRead', function() {
	auth()->user()->unreadnotifications->markAsRead();
});
/*-----------------END DAT ROUTER----------------------*/
