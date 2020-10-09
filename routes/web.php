<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

// 求人
Route::get('/job_cats/{url}', 'CategoryController@getAllCat')->name('allcat');
// お知らせ
Route::get('/jobs/info')->name('info.get');

Route::namespace('Front')->group(function () {
  # 求人
  Route::get('/', 'JobController@index')->name('top.get');
  Route::group(['prefix' => 'jobs'], function () {
    Route::get('{id}', 'JobController@show')->name('jobs.show');
    Route::get('search/all', 'JobController@allJobs')->name('alljobs');
    Route::post('ajax_history_sheet_list', 'JobController@postJobHistory');
  });
  Route::get('history/jobs', 'JobController@getJobHistory')->name('history.get');
  Route::post('search/SearchJobItemAjaxAction', 'JobController@realSearchJob');
  # 求人応募
  Route::get('apply_step1/{id}', 'ApplyController@getApplyStep1')->name('apply.step1.get');
  Route::post('apply_step1/{id}', 'ApplyController@postApplyStep1')->name('apply.step1.post');
  Route::get('apply_step2/{id}', 'ApplyController@getApplyStep2')->name('apply.step2.get');
  Route::post('apply_step2/{id}', 'ApplyController@postApplyStep2')->name('apply.step2.post');
  Route::get('apply_complete/{id}', 'ApplyController@completeJobApply')->name('complete.job.apply');
  //求人キープ機能
  Route::get('keeplist', 'FavouriteController@index')->name('keeplist');
  Route::post('save/{id}', 'FavouriteController@saveJob');
  Route::post('unsave/{id}', 'FavouriteController@unSaveJob');
  //お問い合わせ
  Route::get('contact_s', 'ContactsController@getContactSeeker')->name('contact.s.get');
  Route::get('contact_e', 'ContactsController@getContactEmployer')->name('contact.e.get');
  Route::post('contact_s/complete', 'ContactsController@postContactSeeker')->name('contact.seeker.post');
  Route::post('contact_e/complete', 'ContactsController@postContactEmployer')->name('contact.employer.post');
  // LP・固定ページ
  Route::get('lp', 'PageController@getLp')->name('lp.get');
  Route::get('beginners', 'PageController@getBeginner');
  Route::get('terms_service', 'PageController@getTermsService');
  Route::get('terms_service_e', 'PageController@getTermsServiceE');
  Route::get('ceo', 'PageController@getCeo');
  Route::get('manage_about', 'PageController@getManageAbout');

  Route::group(['middleware' => ['auth:user']], function () {
    //求職者
    Route::get('/mypage/index', 'UserController@index')->name('mypages.index');
    Route::get('/mypage/profile_edit', 'UserProfileController@edit')->name('user.profile.get');
    Route::post('/mypage/profile_create', 'UserProfileController@update')->name('user.profile.post');
    Route::get('/mypage/career_edit', 'UserProfileController@editCareer')->name('user.career.get');
    Route::post('/mypage/career_create', 'UserProfileController@updateCareer')->name('user.career.post');
    Route::post('/mypage/resume', 'UserProfileController@Resume')->name('user.resume.post');
    Route::delete('/mypage/resume/delete', 'UserProfileController@resumeDelete')->name('resume.delete');

    Route::get('/mypage/application', 'UserController@jobAppManage')->name('mypage.jobapp.manage');
    Route::get('/mypage/result_report/{apply_id}', 'UserController@getJobAppReport')->name('mypage.jobapp.report');
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
  });
});

Auth::routes(['verify' => true]);

Route::namespace('Auth')->group(function () {
  Route::group(['prefix' => 'members'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login.post');
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register')->name('user.register.post');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::view('logout', 'auth.logout')->name('user.logout.cpl');

    Route::group(['middleware' => 'auth:user'], function () {
      Route::get('register_complete', 'HomeController@index')->name('home');
      Route::post('logout', 'LoginController@logout')->name('logout');
    });
  });
});

Route::namespace('Employer')->group(function () {
  Route::group(['prefix' => 'employer'], function () {
    # ログイン
    Route::get('login', 'LoginController@showLoginForm')->name('employer.login');
    Route::post('login', 'LoginController@login')->name('employer.login.post');
    # 入力画面
    Route::get('getpage', [
      'uses' => 'RegisterController@index',
      'as' => 'employer.register.index'
    ]);
    # 企業仮登録 確認画面
    Route::post('confirm', [
      'uses' => 'RegisterController@confirm',
      'as' => 'employer.confirm'
    ]);
    # 企業仮登録 完了
    Route::post('register', 'RegisterController@register')->name('employer.register');
    # 企業 本登録
    Route::get('register/verify/{token}', 'RegisterController@showForm');
    Route::post('register/main_confirm', 'RegisterController@mainConfirm')->name('employer.main.confirm');
    Route::post('register/main_register', 'RegisterController@mainRegister')->name('employer.main.register');
    # 企業 仮登録メール再送
    Route::get('verify/resend', 'RegisterController@getVerifyResend');
    Route::post('verify/resend', 'RegisterController@postVerifyResend');
    # 企業 パスワード リセット
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('employer.password.email');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('employer.password.request');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('employer.password.update');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('employer.password.reset');
    Route::get('redirect/passreset', 'ResetPasswordController@redirectPassReset');

    Route::group(['middleware' => ['auth:employer']], function () {
      Route::post('logout',   'LoginController@logout')->name('employer.logout');
    });
  });
});


Route::group(['middleware' => ['auth:employer', 'confirm']], function () {
  Route::get('company/job/create/top', 'JobController@createTop')->name('job.create.top');
  Route::get('company/job/create/step1', 'JobController@createStep1')->name('job.create.step1');
  Route::post('company/job/create/step1', 'JobController@storeStep1')->name('job.store.step1');
  Route::get('company/job/create/step2', 'JobController@createStep2')->name('job.create.step2');

  Route::post('company/job/store/draft/{id?}', 'JobController@storeDraft')->name('job.store.draft');
  Route::post('company/job/store/step2/{id?}', 'JobController@storeStep2')->name('job.store.Step2');
  Route::get('company/job/create/confirm/{id?}', 'JobController@createConfirm')->name('job.create.confirm');
  Route::post('company/job/create/complete/{id?}', 'JobController@storeComplete')->name('job.store.complete');

  //メイン画像
  Route::get('company/job/create/main/image/delete/{id?}', 'MediaController@imageDelete')->name('main.image.delete');
  Route::get('company/job/create/main/image/{id?}', 'MediaController@getMainImage')->name('main.image.get');
  Route::post('company/job/create/main/image/{id?}', 'MediaController@postImage')->name('main.image.post');

  //サブ画像１
  Route::get('company/job/create/sub/image01/delete/{id?}', 'MediaController@imageDelete')->name('sub.image1.delete');
  Route::get('company/job/create/sub/image01/{id?}', 'MediaController@getSubImage1')->name('sub.image1.get');
  Route::post('company/job/create/sub/image01/{id?}', 'MediaController@postImage')->name('sub.image1.post');
  //サブ画像２
  Route::get('company/job/create/sub/image02/delete/{id?}', 'MediaController@imageDelete')->name('sub.image2.delete');
  Route::get('company/job/create/sub/image02/{id?}', 'MediaController@getSubImage2')->name('sub.image2.get');
  Route::post('company/job/create/sub/image02/{id?}', 'MediaController@postImage')->name('sub.image2.post');

  //メイン動画
  Route::get('company/job/create/main/movie/delete/{id?}', 'MediaController@movieDelete')->name('main.movie.delete');
  Route::get('company/job/create/main/movie/{id?}', 'MediaController@getMainMovie')->name('main.movie.get');
  Route::post('company/job/create/main/movie/{id?}', 'MediaController@postMovie')->name('main.movie.post');
  //サブ動画１
  Route::get('company/job/create/sub/movie01/delete/{id?}', 'MediaController@movieDelete')->name('sub.movie1.delete');
  Route::get('company/job/create/sub/movie01/{id?}', 'MediaController@getSubMovie1')->name('sub.movie1.get');
  Route::post('company/job/create/sub/movie01/{id?}', 'MediaController@postMovie')->name('sub.movie1.post');
  //サブ動画２
  Route::get('company/job/create/sub/movie02/delete/{id?}', 'MediaController@movieDelete')->name('sub.movie2.delete');
  Route::get('company/job/create/sub/movie02/{id?}', 'MediaController@getSubMovie2')->name('sub.movie2.get');
  Route::post('company/job/create/sub/movie02/{id?}', 'MediaController@postMovie')->name('sub.movie2.post');


  Route::get('company/joblist/{jobItem}/edit', 'JobController@edit')->name('job.edit');
  Route::post('company/joblist/{id}/edit', 'JobController@update')->name('job.update');
  Route::get('company/joblist/{jobItem}/category/{cat_slug}', 'JobController@catEdit')->name('job.category.edit');
  Route::post('company/joblist/{jobItem}/edit/category/update', 'JobController@catUpdate')->name('job.category.update');



  Route::get('company/joblist', 'JobController@index')->name('my.job');
  Route::get('company/joblist/{jobitem}/myjob-app-delete', 'JobController@getMyjobAppDelete')->name('myjob.app.delete');
  Route::get('company/joblist/{jobitem}/myjob-app-delete-cancel', 'JobController@getMyjobAppDeleteCancel')->name('myjob.app.delete.cancel');
  Route::get('company/joblist/{jobitem}/myjob-app-stop', 'JobController@getMyjobAppStop')->name('myjob.app.stop');
  Route::get('company/joblist/{jobitem}/myjob-app-cancel', 'JobController@getMyjobAppCancel')->name('myjob.app.cancel.get');
  Route::post('company/joblist/{jobitem}/myjob-app-cancel', 'JobController@postMyjobAppCancel')->name('myjob.app.cancel.post');
  Route::get('company/joblist/{jobitem}/show', 'JobController@jobFormShow')->name('job.form.show');
  Route::get('applylist/index', 'JobController@applicant')->name('applicants.view');
  Route::get('applylist/detail/{jobitem_id}/{apply_id}', 'JobController@applicantDetail')->name('applicants.detail');
  Route::get('applylist/detail/adopt/{jobitem_id}/{apply_id}', 'JobController@empAdoptJob')->name('emp.applicant.adopt');
  Route::get('applylist/detail/unadopt/{jobitem_id}/{apply_id}', 'JobController@empUnAdoptJob')->name('emp.applicant.unadopt');
  Route::get('applylist/detail/adopt_cancel/{jobitem_id}/{apply_id}', 'JobController@empAdoptCancelJob')->name('emp.applicant.adopt.cancel');

  Route::group(['prefix' => 'company'], function () {
    #会社・企業
    Route::get('mypage', 'CompanyController@mypageIndex')->name('company.mypage');
    Route::get('edit', 'CompanyController@edit')->name('companies.edit');
    Route::post('edit', 'CompanyController@update')->name('companies.update');
    Route::get('logo', function () {
      return redirect('/company/create');
    });
    Route::post('logo', 'CompanyController@companyLogo')->name('companies.logo');
    Route::delete('logo/delete', 'CompanyController@companyLogoDelete')->name('logo.delete');
    Route::get('delete', 'CompanyController@companyDeleteApp')->name('companies.delete');
    Route::get('delete_cancel', 'CompanyController@companyDeleteAppCancel')->name('companies.delete.cancel');
  });


  //企業マイページからのパスワード ・メールアドレス 変更
  Route::get('changepassword', 'CompanyController@getChangePasswordForm')->name('employer.changepassword.get');
  Route::post('changepassword', 'CompanyController@postChangePassword')->name('employer.changepassword.post');
  Route::get('change_email', 'CompanyController@getChangeEmail')->name('employer.changeemail.get');
  Route::post('change_email', 'CompanyController@postChangeEmail')->name('employer.changeemail.post');
});


Route::post('/dashboard/line_callback', 'Admin\LineController@callback');
// 管理者
Route::group(['prefix' => 'dashboard'], function () {
  Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
  Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login');

  Route::group(['middleware' => ['auth:admin']], function () {
    Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
    Route::get('home', 'Admin\HomeController@index')->name('admin.home')->middleware('admin');

    Route::get('joblist/index', 'DashboardController@getAlljobs')->name('alljob.get');
    Route::get('joblist/sort', 'DashboardController@jobsSort')->name('alljob.sort');
    Route::get('joblist/show/{id}', 'DashboardController@getJobDetail')->name('admin.job.detail');

    Route::get('joblist/{id}/oiwaikin', 'DashboardController@oiwaikinChange')->name('admin.job.oiwaikin.change');

    Route::get('joblist/index/approval_pending', 'DashboardController@getApprovalPendingJobs');
    Route::get('joblist/{id}/Status/{slug}', 'DashboardController@approveJobStatus')->name('job.status.change');

    Route::get('joblist/delete/{id}', 'DashboardController@jobDetete')->name('job.delete');

    Route::get('app_manage', 'DashboardController@getAppManage')->name('admin.app.manage');
    Route::get('oiwaikin/users', 'DashboardController@getOiwaikinUsers')->name('oiwaikin.users.get');
    // Route::get('oiwaikin/users/{id}/detail', 'DashboardController@getOiwaikinUsers')->name('oiwaikin.users.detail.get');
    Route::get('user/{id}/detail', 'DashboardController@getUserDetail')->name('user.detail.get');

    Route::get('billing/top', 'DashboardController@getBilling')->name('billing.index');
    Route::get('billing/year_and_month', 'DashboardController@getBillingYear')->name('billing.year');

    Route::get('companies', 'DashboardController@getAllCompanies')->name('all.company.get');
    Route::get('company/{id}/detail', 'DashboardController@getCompanyDetail')->name('admin.company.detail');

    Route::get('company/{id}/delete', 'DashboardController@companyDelete')->name('admin.company.delete');

    Route::get('category_top', 'DashboardController@categoryTop')->name('admin_category.top');
    Route::get('category/{url}', 'DashboardController@category')->name('admin_category');
    Route::post('category/{flag}/edit', 'DashboardController@editCategory')->name('admin_category_edit');
    Route::post('category/{flag}/delete', 'DashboardController@deleteCategory')->name('admin_category_delete');
  });
});
