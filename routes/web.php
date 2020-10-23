<?php

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
  Route::group(['prefix' => 'job_sheet'], function () {
    Route::get('{jobitem}', 'JobController@show')->name('show.front.job_sheet.detail');
    Route::get('search/all', 'JobController@search')->name('index.front.job_sheet.search');
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
  // 求人票
  Route::get('company/jobs/create/top', 'JobController@createTop')->name('index.jobsheet.top');
  Route::get('company/jobs/create/step1', 'JobController@createStep1')->name('index.jobsheet.step1');
  Route::post('company/jobs/step1', 'JobController@storeStep1')->name('store.jobsheet.step1');
  Route::get('company/jobs/create/step2/{jobitem}', 'JobController@editStep2')->name('edit.jobsheet.step2');

  Route::put('company/jobs/create/step2/{jobitem}/draftOrConfirm', 'JobController@storeDraftOrConfirm')->name('draftOrConfirm.jobsheet.step2');
  Route::get('company/jobs/create/step2/{jobitem}/confirm', 'JobController@showStep2Confirm')->name('show.jobsheet.step2.confirm');
  Route::put('company/jobs/create/step2/{jobitem}', 'JobController@updateStep2')->name('update.jobsheet.step2');

  //メイン画像
  Route::get('company/jobs/create/delete_image/{jobitem}', 'MediaController@deleteImage')->name('delete.jobsheet.image');
  Route::get('company/jobs/create/register_mainimage/{jobitem}', 'MediaController@editMainImage')->name('edit.jobsheet.mainimage');
  Route::post('company/jobs/create/register_mainimage/{jobitem}', 'MediaController@updateImage')->name('update.jobsheet.mainimage');
  //サブ画像1
  Route::get('company/jobs/create/register_subimage1/{jobitem}', 'MediaController@editSubImage1')->name('edit.jobsheet.subimage1');
  Route::post('company/jobs/create/register_subimage1/{jobitem}', 'MediaController@updateImage')->name('update.jobsheet.subimage1');
  //サブ画像2
  Route::get('company/jobs/create/register_subimage2/{jobitem}', 'MediaController@editSubImage2')->name('edit.jobsheet.subimage2');
  Route::post('company/jobs/create/register_subimage2/{jobitem}', 'MediaController@updateImage')->name('update.jobsheet.subimage2');

  //メイン動画
  Route::get('company/jobs/create/delete_movie/{jobitem}', 'MediaController@deleteMovie')->name('delete.jobsheet.movie');
  Route::get('company/jobs/create/register_mainmovie/{jobitem}', 'MediaController@editMainMovie')->name('edit.jobsheet.mainmovie');
  Route::post('company/jobs/create/register_mainmovie/{jobitem}', 'MediaController@updateMovie')->name('update.jobsheet.mainmovie');
  //サブ動画１
  Route::get('company/jobs/create/register_submovie1/{jobitem}', 'MediaController@editSubMovie1')->name('edit.jobsheet.submovie1');
  Route::post('company/jobs/create/register_submovie1/{jobitem}', 'MediaController@updateMovie')->name('update.jobsheet.submovie1');
  //サブ動画２
  Route::get('company/jobs/create/register_submovie2/{jobitem}', 'MediaController@editSubMovie2')->name('edit.jobsheet.submovie2');
  Route::post('company/jobs/create/register_submovie2/{jobitem}', 'MediaController@updateMovie')->name('update.jobsheet.submovie2');

  Route::get('company/jobs/create/step2/{jobitem}/category/{cat_slug}', 'JobController@editCategory')->name('edit.jobsheet.category');
  Route::post('company/jobs/create/step2/{jobitem}/category/update', 'JobController@updateCategory')->name('update.jobsheet.category');

  Route::get('company/joblist', 'JobController@index')->name('index.joblist');
  Route::get('company/joblist/{jobitem}', 'JobController@show')->name('show.joblist.detail');

  // ステータス変更
  Route::get('company/joblist/{jobitem}/myjob-app-stop', 'JobController@getMyjobAppStop')->name('myjob.app.stop');

  Route::get('company/joblist/job/apply_cancel/{jobitem}', 'JobItemStatusController@editStatusApplyCancel')->name('edit.jobsheet.status.apply_cancel');
  Route::put('company/joblist/job/apply_cancel/{jobitem}', 'JobItemStatusController@updateStatus')->name('update.jobsheet.status.apply_cancel');

  Route::get('company/joblist/job/postend/{jobitem}', 'JobItemStatusController@editStatusStopPosting')->name('edit.jobsheet.status.postend');
  Route::put('company/joblist/job/postend/{jobitem}', 'JobItemStatusController@updateStatus')->name('update.jobsheet.status.postend');
  Route::get('company/joblist/job/delete/{jobitem}', 'JobItemStatusController@editStatusDelete');

  // 応募者
  Route::get('applylist/index', 'JobController@applicant')->name('applicants.view');
  Route::get('applylist/detail/{jobitem_id}/{apply_id}', 'JobController@applicantDetail')->name('applicants.detail');
  Route::get('applylist/detail/adopt/{jobitem_id}/{apply_id}', 'JobController@empAdoptJob')->name('emp.applicant.adopt');
  Route::get('applylist/detail/unadopt/{jobitem_id}/{apply_id}', 'JobController@empUnAdoptJob')->name('emp.applicant.unadopt');
  Route::get('applylist/detail/adopt_cancel/{jobitem_id}/{apply_id}', 'JobController@empAdoptCancelJob')->name('emp.applicant.adopt.cancel');

  Route::group(['prefix' => 'company'], function () {
    #会社・企業
    Route::get('mypage', 'CompanyController@mypageIndex')->name('index.company.mypage');
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
    Route::get('user/{id}/detail', 'DashboardController@getUserDetail')->name('user.detail.get');

    Route::get('billing/top', 'DashboardController@getBilling')->name('billing.index');
    Route::get('billing/year_and_month', 'DashboardController@getBillingYear')->name('billing.year');

    Route::get('companies', 'DashboardController@getAllCompanies')->name('all.company.get');
    Route::get('company/{id}/detail', 'DashboardController@getCompanyDetail')->name('admin.company.detail');

    Route::get('company/{id}/delete', 'DashboardController@companyDelete')->name('admin.company.delete');

    // システム設定
    Route::group(['prefix' => 'setting'], function () {
      Route::get('category_top', 'DashboardController@categoryTop')->name('admin_category.top');
      Route::get('category/{url}', 'DashboardController@category')->name('admin_category');
      Route::post('category/{flag}/edit', 'DashboardController@editCategory')->name('admin_category_edit');
      Route::post('category/{flag}/delete', 'DashboardController@deleteCategory')->name('admin_category_delete');
      Route::get('monies/{flag}', 'DashboardController@getSettingMonies')->name('admin.get.monies');
      Route::post('monies/{flag}/edit', 'DashboardController@editSettingMoney')->name('admin.post.money');
    });
  });
});
