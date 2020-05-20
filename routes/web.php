<?php

use Illuminate\Http\Request;


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

// job
Route::get('/', 'JobController@index');
Route::get('/job_cats/{url}', 'CategoryController@getAllCat')->name('allcat');

Route::get('/jobs/create/top', 'JobController@createTop')->name('job.create.top');
Route::get('/jobs/create/step1', 'JobController@createStep1')->name('job.create.step1');
Route::post('/jobs/create/step1', 'JobController@storeStep1')->name('job.store.step1');
Route::get('/jobs/create/step2', 'JobController@createStep2')->name('job.create.step2');

Route::post('/jobs/create/draftOrStep2/{id?}', 'JobController@draftOrStep2')->name('job.draftOrStep2');
Route::get('/jobs/create/confirm/{id?}', 'JobController@createConfirm')->name('job.create.confirm');
Route::post('/jobs/create/complete/{id?}', 'JobController@storeComplete')->name('job.store.complete');

//main image
Route::get('/jobs/main/image/delete/{id?}', 'MediaController@imageDelete')->name('main.image.delete');
Route::get('/jobs/main/image/{id?}', 'MediaController@getMainImage')->name('main.image.get');
Route::post('/jobs/main/image/{id?}', 'MediaController@postImage')->name('main.image.post');

//sub image1
Route::get('/jobs/sub/image01/delete/{id?}', 'MediaController@imageDelete')->name('sub.image1.delete');
Route::get('/jobs/sub/image01/{id?}', 'MediaController@getSubImage1')->name('sub.image1.get');
Route::post('/jobs/sub/image01/{id?}', 'MediaController@postImage')->name('sub.image1.post');
//sub image2
Route::get('/jobs/sub/image02/delete/{id?}', 'MediaController@imageDelete')->name('sub.image2.delete');
Route::get('/jobs/sub/image02/{id?}', 'MediaController@getSubImage2')->name('sub.image2.get');
Route::post('/jobs/sub/image02/{id?}', 'MediaController@postImage')->name('sub.image2.post');

//main movie
Route::get('/jobs/main/movie/delete/{id?}', 'MediaController@movieDelete')->name('main.movie.delete');
Route::get('/jobs/main/movie/{id?}', 'MediaController@getMainMovie')->name('main.movie.get');
Route::post('/jobs/main/movie/{id?}', 'MediaController@postMovie')->name('main.movie.post');
//sub movie1
Route::get('/jobs/sub/movie01/delete/{id?}', 'MediaController@movieDelete')->name('sub.movie1.delete');
Route::get('/jobs/sub/movie01/{id?}', 'MediaController@getSubMovie1')->name('sub.movie1.get');
Route::post('/jobs/sub/movie01/{id?}', 'MediaController@postMovie')->name('sub.movie1.post');
//sub movie2
Route::get('/jobs/sub/movie02/delete/{id?}', 'MediaController@movieDelete')->name('sub.movie2.delete');
Route::get('/jobs/sub/movie02/{id?}', 'MediaController@getSubMovie2')->name('sub.movie2.get');
Route::post('/jobs/sub/movie02/{id?}', 'MediaController@postMovie')->name('sub.movie2.post');

// 最近見た求人
Route::post('/jobs/ajax_history_sheet_list', 'JobController@postJobHistory');

Route::get('/jobs/{id}/edit', 'JobController@edit')->name('job.edit');
Route::post('/jobs/{id}/edit', 'JobController@update')->name('job.update');
Route::get('/jobs/edit/category/{id}/{category}', 'JobController@catEdit')->name('job.category.edit');
Route::post('/jobs/edit/category/{id}/update', 'JobController@catUpdate')->name('job.category.update');

Route::get('/jobs/myjob', 'JobController@myJob')->name('my.job');
Route::get('/jobs/{id}/myjob-app-delete', 'JobController@getMyjobAppDelete')->name('myjob.app.delete');
Route::get('/jobs/{id}/myjob-app-delete-cancel', 'JobController@getMyjobAppDeleteCancel')->name('myjob.app.delete.cancel');
Route::get('/jobs/{id}/myjob-app-stop', 'JobController@getMyjobAppStop')->name('myjob.app.stop');
Route::get('/jobs/{id}/myjob-app-cancel', 'JobController@getMyjobAppCancel')->name('myjob.app.cancel.get');
Route::post('/jobs/{id}/myjob-app-cancel', 'JobController@postMyjobAppCancel')->name('myjob.app.cancel.post');
Route::get('/jobs/{id}/form-show', 'JobController@jobFormShow')->name('job.form.show');
Route::get('/jobs/applications', 'JobController@applicant')->name('applicants.view');
Route::get('/applications/{id}/{user_id}', 'JobController@applicantDetail')->name('applicants.detail');
Route::get('/applications/adopt/{id}/{user_id}', 'JobController@empAdoptJob')->name('emp.applicant.adopt');
Route::get('/applications/unadopt/{id}/{user_id}', 'JobController@empUnAdoptJob')->name('emp.applicant.unadopt');
Route::get('/applications/adopt_cancel/{id}/{user_id}', 'JobController@empAdoptCancelJob')->name('emp.applicant.adopt.cancel');

//job apply
Route::get('/apply_step1/{id}', 'JobController@getApplyStep1')->name('apply.step1.get');
Route::post('/apply_step1/{id}', 'JobController@postApplyStep1')->name('apply.step1.post');
Route::get('/apply_step2/{id}', 'JobController@getApplyStep2')->name('apply.step2.get');
Route::post('/apply_step2/{id}', 'JobController@postApplyStep2')->name('apply.step2.post');
Route::get('/apply_complete/{id}', 'JobController@completeJobApply')->name('complete.job.apply');

Route::get('/jobs/{id}', 'JobController@show')->name('jobs.show');
Route::get('/jobs/search/all', 'JobController@allJobs')->name('alljobs');
Route::post('/search/SearchJobItemAjaxAction','JobController@realSearchJob');

Route::get('/lp', 'PageController@getLp');
Route::get('/beginners', 'PageController@getBeginner');
Route::get('/terms_service', 'PageController@getTermsService');
Route::get('/terms_service_e', 'PageController@getTermsServiceE');
Route::get('/ceo', 'PageController@getCeo');
Route::get('/manage_about', 'PageController@getManageAbout');

//company
Route::get('/company/mypage', 'CompanyController@mypageIndex')->name('company.mypage');
Route::get('company/create', 'CompanyController@create')->name('companies.view');
Route::post('company/create', 'CompanyController@mypageStore')->name('companies.store');
Route::get('company/logo', function(){
  return redirect('/company/create');
});
Route::post('company/logo', 'CompanyController@companyLogo')->name('companies.logo');
Route::delete('/company/logo/delete', 'CompanyController@companyLogoDelete')->name('logo.delete');
Route::get('company/delete', 'CompanyController@companyDeleteApp')->name('companies.delete');
Route::get('company/delete_cancel', 'CompanyController@companyDeleteAppCancel')->name('companies.delete.cancel');

//求人キープ機能
Route::get('/keeplist', 'FavouriteController@index')->name('keeplist');
Route::post('/save/{id}', 'FavouriteController@saveJob');
Route::post('/unsave/{id}', 'FavouriteController@unSaveJob');

//contact
Route::get('contact_s', 'ContactsController@getContactSeeker');
Route::get('contact_e', 'ContactsController@getContactEmployer');
Route::post('contact_s/complete', 'ContactsController@postContactSeeker')->name('contact.seeker.post');
Route::post('contact_e/complete', 'ContactsController@postContactEmployer')->name('contact.employer.post');


//user
Route::get('/mypage/index', 'UserController@index')->name('mypages.index');
Route::get('/mypage/profile_edit', 'UserController@create');
Route::post('/mypage/profile_create', 'UserController@store')->name('mypages.create');
Route::get('/mypage/career_edit', 'UserController@careerCreate');
Route::post('/mypage/career_create', 'UserController@careerStore')->name('mypages.career.create');
Route::post('/mypage/resume', 'UserController@Resume')->name('resume');
Route::delete('/mypage/resume/delete', 'UserController@resumeDelete')->name('resume.delete');

Route::get('/mypage/application', 'UserController@jobAppManage')->name('mypage.jobapp.manage');
Route::get('/mypage/result_report/{id}', 'UserController@getJobAppReport')->name('mypage.jobapp.report');
Route::get('/mypage/apply_festive_money/{id}', 'UserController@getAppFesMoney')->name('app.fesmoney.get');
Route::post('/mypage/apply_festive_money/{id}', 'UserController@postAppFesMoney')->name('app.fesmoney.post');
Route::get('/mypage/unadopt/{id}', 'UserController@unAdoptJob')->name('appjob.unadopt');
Route::get('/mypage/adopt_cancel/{id}', 'UserController@adoptCancelJob')->name('appjob.cancel');
Route::get('/mypage/adopt_decline/{id}', 'UserController@jobDecline')->name('appjob.decline');
Route::get('/mypage/changepassword', 'UserController@getChangePasswordForm')->name('mypage.changepassword.get');
Route::post('/mypage/changepassword', 'UserController@postChangePassword')->name('mypage.changepassword.post');
Route::get('/mypage/change_email', 'UserController@getChangeEmail')->name('mypage.changeemail.get');
Route::post('/mypage/change_email', 'UserController@postChangeEmail')->name('mypage.changeemail.post');

Route::get('/mypage/delete', 'UserController@userDelete')->name('mypage.delete');

Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| 1) User 認証不要
|--------------------------------------------------------------------------
*/
  Route::get('members/login', 'Auth\LoginController@showLoginForm')->name('login');
  Route::post('members/login', 'Auth\LoginController@login')->name('login.post');
  Route::get('members/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
  Route::post('members/register', 'Auth\RegisterController@register');

  Route::get('members/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('members/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
  Route::get('members/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('members/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

  Route::view('members/logout', 'auth.logout');

/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:user'], function() {

  Route::get('/members/register_complete', 'HomeController@index')->name('home');
  Route::post('members/logout', 'Auth\LoginController@logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| 3) Employer 認証不要
|--------------------------------------------------------------------------
*/
// Route::get('/company/register/complete', 'Employer\LoginController@verifyAfter');
Route::group(['prefix' => 'employer'], function() {
  // Route::get('home',  'Employer\HomeController@index')->name('employer.home');
  Route::get('login',     'Employer\LoginController@showLoginForm')->name('employer.login');
  Route::post('login',    'Employer\LoginController@login')->name('employer.login.post')->middleware('confirm');

  //employer register
  # 入力画面
  Route::get('getpage', [
      'uses' => 'Employer\RegisterController@index',
      'as' => 'employer.register.index'
  ]);

  # 確認画面

  Route::post('confirm', [
    'uses' => 'Employer\RegisterController@confirm',
    'as' => 'employer.confirm'
  ]);
  // Route::get('register', function(){
  //   return redirect('/employer/getpage');
  // });
  Route::post('register', 'Employer\RegisterController@register')->name('employer.register');



  //  employer main register
  Route::get('register/verify/{token}', 'Employer\RegisterController@showForm');
  Route::post('register/main_confirm', 'Employer\RegisterController@mainConfirm')->name('employer.main.confirm');
  Route::post('register/main_register', 'Employer\RegisterController@mainRegister')->name('employer.main.register');

  //仮登録メール再送
  Route::get('verify/resend', 'Employer\RegisterController@getVerifyResend');
  Route::post('verify/resend', 'Employer\RegisterController@postVerifyResend');

  Route::post('password/email', 'Employer\ForgotPasswordController@sendResetLinkEmail')->name('employer.password.email');
  Route::get('password/reset', 'Employer\ForgotPasswordController@showLinkRequestForm')->name('employer.password.request');
  Route::post('password/reset', 'Employer\ResetPasswordController@reset')->name('employer.password.update');
  Route::get('password/reset/{token}', 'Employer\ResetPasswordController@showResetForm')->name('employer.password.reset');
  Route::get('redirect/passreset', 'Employer\ResetPasswordController@redirectPassReset');

   //email password 変更
  Route::get('changepassword', 'CompanyController@getChangePasswordForm')->name('employer.changepassword.get');
  Route::post('changepassword', 'CompanyController@postChangePassword')->name('employer.changepassword.post');
  Route::get('change_email', 'CompanyController@getChangeEmail')->name('employer.changeemail.get');
  Route::post('change_email', 'CompanyController@postChangeEmail')->name('employer.changeemail.post');
});




/*
|--------------------------------------------------------------------------
| 4) Employer ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'employer', 'middleware' => 'auth:employer'], function() {
  Route::post('logout',   'Employer\LoginController@logout')->name('employer.logout');
});


// admin
Route::group(['prefix' => 'dashboard'], function(){
  Route::get('home', 'Admin\HomeController@index')->name('admin.home')->middleware('admin');
  Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
  Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login');
  Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

  Route::get('jobs', 'DashboardController@getAlljobs')->name('alljob.get');
  Route::get('jobs/sort', 'DashboardController@jobsSort')->name('alljob.sort');
  Route::get('job/{id}/detail', 'DashboardController@getJobDetail')->name('admin.job.detail');

  Route::get('job/{id}/oiwaikin', 'DashboardController@oiwaikinChange')->name('admin.job.oiwaikin.change');

  Route::get('jobs/approval_pending', 'DashboardController@getApprovalPendingJobs');
  Route::get('job/{id}/status_approve', 'DashboardController@approeJobStatus')->name('job.approve');
  Route::get('job/{id}/status_non_approve', 'DashboardController@nonApproeJobStatus')->name('job.non.approve');
  Route::get('job/{id}/status_non_public', 'DashboardController@nonPublicJobStatus')->name('job.non.public');
  Route::get('job/{id}/delete', 'DashboardController@jobDetete')->name('job.delete');


  Route::get('app_manage', 'DashboardController@getAppManage')->name('admin.app.manage');
  Route::get('oiwaikin/users', 'DashboardController@getOiwaikinUsers')->name('oiwaikin.users.get');
  // Route::get('oiwaikin/users/{id}/detail', 'DashboardController@getOiwaikinUsers')->name('oiwaikin.users.detail.get');
  Route::get('user/{id}/detail', 'DashboardController@getUserDetail')->name('user.detail.get');

  Route::get('billing/top', 'DashboardController@getBilling')->name('billing.index');
  Route::get('billing/year_and_month', 'DashboardController@getBillingYear')->name('billing.year');

  Route::get('companies', 'DashboardController@getAllCompanies')->name('all.company.get');
  Route::get('companies/sort', 'DashboardController@companiesSort')->name('all.company.sort');
  Route::get('company/{id}/detail', 'DashboardController@getCompanyDetail')->name('admin.company.detail');

  Route::get('company/{id}/delete', 'DashboardController@employerDelete')->name('admin.company.delete');

  Route::get('category_top', 'DashboardController@categoryTop')->name('admin_category.top');
  Route::get('category/{url}', 'DashboardController@category')->name('admin_category');
  Route::post('category/{flag}/edit', 'DashboardController@editCategory')->name('admin_category_edit');
  Route::post('category/{flag}/delete', 'DashboardController@deleteCategory')->name('admin_category_delete');
});
