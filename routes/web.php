<?php

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

// お知らせ
Route::get('/jobs/info')->name('info.get');

Route::namespace('Front')->group(function () {
  # 求人
  Route::get('/', 'JobController@index')->name('index.front.top');
  Route::group(['prefix' => 'job_sheet'], function () {
    Route::get('{jobitem}', 'JobController@show')->name('show.front.job_sheet.detail');
    Route::get('search/all', 'JobController@search')->name('index.front.job_sheet.search');

    Route::post('ajax_history_sheet_list', 'JobController@postJobHistory');
  });

  Route::get('reward_request', 'RewardController@create')->name('create.front.reward');
  Route::post('reward_request', 'RewardController@store')->name('store.front.reward');

  Route::get('/category/{url}', 'CategoryController@index')->name('index.front.category');

  // 閲覧履歴
  Route::get('history', 'JobController@indexHistory')->name('index.front.job_sheet.history');
  //お気に入り
  Route::get('keeplist', 'FavouriteController@index')->name('index.front.job_sheet.keeplist');
  Route::post('keeplist/save/{id}', 'FavouriteController@saveJob');
  Route::post('keeplist/unsave/{id}', 'FavouriteController@unSaveJob');

  # 求人応募
  Route::get('entry/step1/{jobitem}/job_sheet', 'ApplyController@showStep1')->name('show.front.entry.step1');
  Route::post('entry/step1/{jobitem}/job_sheet', 'ApplyController@storeStep1')->name('store.front.entry.step1');
  Route::get('entry/step2/{jobitem}/job_sheet', 'ApplyController@showStep2')->name('show.front.entry.step2');
  Route::post('entry/step2/{jobitem}/job_sheet', 'ApplyController@storeStep2')->name('store.front.entry.step2');
  Route::get('entry/finish/{jobitem}/job_sheet', 'ApplyController@showFinish')->name('show.front.entry.finish');

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
});

//求職者
Route::group(['middleware' => 'auth:seeker', 'prefix' => 'mypage', 'namespace' => 'Seeker'], function () {
  Route::get('index', 'UserController@index')->name('seeker.index.mypage');
  Route::get('edit', 'UserProfileController@edit')->name('seeker.edit.profile');
  Route::put('edit', 'UserProfileController@update')->name('seeker.update.profile');
  Route::get('career_edit', 'UserProfileController@editCareer')->name('seeker.edit.career');
  Route::put('career_edit', 'UserProfileController@updateCareer')->name('seeker.update.career');

  Route::get('application', 'JobController@index')->name('seeker.index.job');
  Route::get('application/{apply}', 'JobController@showReport')->name('seeker.show.job');
  Route::get('application/{apply}/report', 'JobController@editReport')->name('seeker.edit.report');
  Route::put('application/{apply}/report', 'JobController@updateReport')->name('seeker.update.report');

  Route::get('changepassword', 'UserController@getChangePasswordForm')->name('seeker.mypage.changepassword.get');
  Route::post('changepassword', 'UserController@postChangePassword')->name('seeker.mypage.changepassword.post');
  Route::get('change_email', 'UserController@getChangeEmail')->name('seeker.mypage.changeemail.get');
  Route::post('change_email', 'UserController@postChangeEmail')->name('seeker.mypage.changeemail.post');

  Route::delete('delete', 'UserController@delete')->name('seeker.delete');
});

Route::group(['prefix' => 'members', 'namespace' => 'Seeker\Auth'], function () {
  Route::get('login', 'LoginController@showLoginForm')->name('seeker.login');
  Route::post('login', 'LoginController@login')->name('seeker.login.post');
  Route::get('register', 'RegisterController@showRegistrationForm')->name('seeker.register');
  Route::post('register', 'RegisterController@register')->name('seeker.register.post');
  Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('seeker.password.request');
  Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('seeker.password.email');
  Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('seeker.password.reset');
  Route::post('password/reset', 'ResetPasswordController@reset')->name('seeker.password.update');
  Route::view('logout', 'auth.logout')->name('seeker.logout.cpl');

  Route::group(['middleware' => 'auth:seeker'], function () {
    Route::get('register_complete', 'RegisterController@complete');
    Route::post('logout', 'LoginController@logout')->name('seeker.logout');
  });
});

Route::group(['prefix' => 'enterprise'], function () {
  Route::group(['namespace' => 'Employer\Auth'], function () {
    # ログイン
    Route::get('login', 'LoginController@showLoginForm')->name('employer.login');
    Route::post('login', 'LoginController@login')->name('employer.login.post');
    # 企業 仮登録
    Route::get('register', 'RegisterController@index')->name('employer.register.index');
    Route::post('confirm', 'RegisterController@confirm')->name('employer.confirm');
    Route::post('register', 'RegisterController@register')->name('employer.register');
    Route::get('register_finish', 'RegisterController@finishRegister')->name('employer.pre_register.finish');
    # 企業 本登録
    Route::get('register/verify/{token}', 'RegisterController@showForm');
    Route::post('register/main_confirm', 'RegisterController@mainConfirm')->name('employer.main.confirm');
    Route::post('register/main_register', 'RegisterController@mainRegister')->name('employer.main.register');
    Route::get('register/main_register_finish', 'RegisterController@finishMainRegister')->name('employer.main_register.finish');
    # 企業 仮登録メール再送
    Route::get('verify/resend', 'RegisterController@getVerifyResend')->name('index.mailform.resend.preregister');
    Route::post('verify/resend', 'RegisterController@postVerifyResend')->name('store.mailform.resend.preregister');
    # 企業 パスワード リセット
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('employer.password.email');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('employer.password.request');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('employer.password.update');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('employer.password.reset');
    Route::post('logout',   'LoginController@logout')->name('employer.logout');
  });
  Route::group(['namespace' => 'Employer'], function () {
    Route::group(['middleware' => ['auth:employer', 'confirm']], function () {
      // 求人票
      Route::get('jobs/create/step1', 'JobItemController@createStep1')->name('enterprise.index.jobsheet.step1');
      Route::post('obs/create/step1', 'JobItemController@storeStep1')->name('enterprise.store.jobsheet.step1');
      Route::get('jobs/create/step2/{jobitem}', 'JobItemController@editStep2')->name('enterprise.edit.jobsheet.step2');

      Route::put('jobs/create/step2/{jobitem}/draftOrConfirm', 'JobItemController@storeDraftOrConfirm')->name('enterprise.draftOrConfirm.jobsheet.step2');
      Route::get('jobs/create/step2/{jobitem}/confirm', 'JobItemController@showStep2Confirm')->name('enterprise.show.jobsheet.step2.confirm');
      Route::put('jobs/create/step2/{jobitem}', 'JobItemController@updateStep2')->name('enterprise.update.jobsheet.step2');

      //メイン画像
      Route::get('jobs/create/delete_image/{jobitem}', 'MediaController@deleteImage')->name('enterprise.delete.jobsheet.image');
      Route::get('jobs/create/register_mainimage/{jobitem}', 'MediaController@editMainImage')->name('enterprise.edit.jobsheet.mainimage');
      Route::post('jobs/create/register_mainimage/{jobitem}', 'MediaController@updateImage')->name('enterprise.update.jobsheet.mainimage');
      //サブ画像1
      Route::get('jobs/create/register_subimage1/{jobitem}', 'MediaController@editSubImage1')->name('enterprise.edit.jobsheet.subimage1');
      Route::post('jobs/create/register_subimage1/{jobitem}', 'MediaController@updateImage')->name('enterprise.update.jobsheet.subimage1');
      //サブ画像2
      Route::get('jobs/create/register_subimage2/{jobitem}', 'MediaController@editSubImage2')->name('enterprise.edit.jobsheet.subimage2');
      Route::post('jobs/create/register_subimage2/{jobitem}', 'MediaController@updateImage')->name('enterprise.update.jobsheet.subimage2');

      //メイン動画
      Route::get('jobs/create/delete_movie/{jobitem}', 'MediaController@deleteMovie')->name('enterprise.delete.jobsheet.movie');
      Route::get('jobs/create/register_mainmovie/{jobitem}', 'MediaController@editMainMovie')->name('enterprise.edit.jobsheet.mainmovie');
      Route::post('jobs/create/register_mainmovie/{jobitem}', 'MediaController@updateMovie')->name('enterprise.update.jobsheet.mainmovie');
      //サブ動画１
      Route::get('jobs/create/register_submovie1/{jobitem}', 'MediaController@editSubMovie1')->name('enterprise.edit.jobsheet.submovie1');
      Route::post('jobs/create/register_submovie1/{jobitem}', 'MediaController@updateMovie')->name('enterprise.update.jobsheet.submovie1');
      //サブ動画２
      Route::get('jobs/create/register_submovie2/{jobitem}', 'MediaController@editSubMovie2')->name('enterprise.edit.jobsheet.submovie2');
      Route::post('jobs/create/register_submovie2/{jobitem}', 'MediaController@updateMovie')->name('enterprise.update.jobsheet.submovie2');

      Route::get('jobs/create/step2/{jobitem}/category/{cat_slug}', 'JobItemController@editCategory')->name('enterprise.edit.jobsheet.category');
      Route::post('jobs/create/step2/{jobitem}/category', 'JobItemController@updateCategory')->name('enterprise.update.jobsheet.category');
      Route::get('jobs/create/step2/category/update/finish', 'JobItemController@showCategoryFinish')->name('enterprise.show.jobsheet.category.finish');

      Route::get('joblist', 'JobItemController@index')->name('enterprise.index.joblist');
      Route::get('joblist/{jobitem}', 'JobItemController@show')->name('enterprise.show.joblist.detail');

      // ステータス変更
      Route::get('joblist/job/apply_cancel/{jobitem}', 'JobItemStatusController@editStatusApplyCancel')->name('enterprise.edit.jobsheet.status.apply_cancel');
      Route::put('joblist/job/apply_cancel/{jobitem}', 'JobItemStatusController@updateStatus')->name('enterprise.update.jobsheet.status.apply_cancel');
      Route::get('joblist/job/postend/{jobitem}', 'JobItemStatusController@editStatusStopPosting')->name('enterprise.edit.jobsheet.status.postend');
      Route::put('joblist/job/postend/{jobitem}', 'JobItemStatusController@updateStatus')->name('enterprise.update.jobsheet.status.postend');
      Route::get('joblist/job/delete/{jobitem}', 'JobItemStatusController@editStatusDelete');
      // 応募者
      Route::get('applications/index', 'ApplicationController@index')->name('enterprise.index.application');
      Route::get('applications/{apply}', 'ApplicationController@show')->name('enterprise.show.application');
      Route::get('applications/{apply}/report', 'ApplicationController@showReportForm')->name('enterprise.show.application.report');
      Route::put('applications/{apply}/report', 'ApplicationController@updateReport')->name('enterprise.update.application.report');
      Route::get('applications/index/unadopt_decline', 'ApplicationController@getUnadoptOrDecline')->name('enterprise.get.application.unadopt_or_decline');
      #会社・企業
      Route::get('mypage', 'CompanyController@index')->name('enterprise.index.mypage');
      Route::get('edit', 'CompanyController@edit')->name('enterprise.edit.profile');
      Route::post('edit', 'CompanyController@update')->name('enterprise.update.profile');
      //企業マイページからのパスワード ・メールアドレス 変更
      Route::get('changepassword', 'CompanyController@getChangePasswordForm')->name('enterprise.changepassword.get');
      Route::post('changepassword', 'CompanyController@postChangePassword')->name('enterprise.changepassword.post');
      Route::get('change_email', 'CompanyController@getChangeEmail')->name('enterprise.changeemail.get');
      Route::post('change_email', 'CompanyController@postChangeEmail')->name('enterprise.changeemail.post');
    });
  });
});

Route::post('/dashboard/line_callback', 'Admin\LineController@callback');
// 管理者
Route::group(['prefix' => 'admin'], function () {
  Route::namespace('Admin')->group(function () {
    Route::namespace('Auth')->group(function () {
      Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
      Route::post('login', 'LoginController@login')->name('admin.login');
      Route::post('logout', 'LoginController@logout')->name('admin.logout');
      // Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
      // Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
      // Route::post('password/reset', 'ResetPasswordController@reset')->name('admin.password.update');
      // Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    });

    Route::group(['middleware' => ['auth:admin']], function () {
      Route::get('/', 'DashboardController@index');
      Route::resource('dashboard', 'DashboardController')->only([
        'index'
      ]);
      Route::group(['prefix' => 'data'], function () {
        Route::resource('job_sheet', 'JobItemController')->except(['create', 'store', 'destroy']);
        Route::resource('application', 'ApplicationController')->except(['create', 'store', 'destroy']);
        Route::resource('reward', 'RewardController')->except(['create', 'store', 'destroy']);
        Route::resource('enterprise', 'EnterpriseController')->except(['create', 'store', 'destroy']);
      });

      // Route::get('joblist/index', 'DashboardController@getAlljobs')->name('alljob.get');
      // Route::get('joblist/sort', 'DashboardController@jobsSort')->name('alljob.sort');
      // Route::get('joblist/show/{id}', 'DashboardController@getJobDetail')->name('admin.job.detail');

      // Route::get('joblist/{id}/oiwaikin', 'DashboardController@oiwaikinChange')->name('admin.job.oiwaikin.change');

      // Route::get('joblist/index/approval_pending', 'DashboardController@getApprovalPendingJobs');
      // Route::get('joblist/{id}/Status/{slug}', 'DashboardController@approveJobStatus')->name('job.status.change');

      // Route::get('joblist/delete/{id}', 'DashboardController@jobDetete')->name('job.delete');

      // Route::get('app_manage', 'DashboardController@getAppManage')->name('admin.app.manage');
      // Route::get('oiwaikin/users', 'DashboardController@getOiwaikinUsers')->name('oiwaikin.users.get');
      // Route::get('user/{id}/detail', 'DashboardController@getUserDetail')->name('user.detail.get');

      // Route::get('billing/top', 'DashboardController@getBilling')->name('billing.index');
      // Route::get('billing/year_and_month', 'DashboardController@getBillingYear')->name('billing.year');

      // Route::get('companies', 'DashboardController@getAllCompanies')->name('all.company.get');
      // Route::get('company/{id}/detail', 'DashboardController@getCompanyDetail')->name('admin.company.detail');

      // Route::get('company/{id}/delete', 'DashboardController@companyDelete')->name('admin.company.delete');

      // システム設定
      // Route::group(['prefix' => 'setting'], function () {
      //   Route::get('category_top', 'DashboardController@categoryTop')->name('admin_category.top');
      //   Route::get('category/{url}', 'DashboardController@category')->name('admin_category');
      //   Route::post('category/{flag}/edit', 'DashboardController@editCategory')->name('admin_category_edit');
      //   Route::post('category/{flag}/delete', 'DashboardController@deleteCategory')->name('admin_category_delete');
      //   Route::get('monies/{flag}', 'DashboardController@getSettingMonies')->name('admin.get.monies');
      //   Route::post('monies/{flag}/edit', 'DashboardController@editSettingMoney')->name('admin.post.money');
      // });
    });
  });
});
