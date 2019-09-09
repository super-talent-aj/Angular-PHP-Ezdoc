<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
  Route::get('hello', 'PrintController@hello');
  Route::get('test', 'PrintController@test');

  Route::post('printHtml', [
    'as' => 'api.print.printHtml',
    'middleware' => 'jwt.auth',
    'uses' => 'PrintController@printHtml',
  ]);

  Route::get('downloadDoc', [
    'as' => 'api.print.download',
    'middleware' => 'jwt.auth',
    'uses' => 'PrintController@download',
  ]);

  Route::get('getCaptcha', [
    'as' => 'api.auth.getcaptcha',
    'uses' => 'AuthController@getCaptcha',
  ]);

  Route::post('checkCaptcha', [
    'as' => 'api.auth.checkcaptcha',
    'uses' => 'AuthController@checkCaptcha',
  ]);

  Route::post('login', [
    'as' => 'api.session.store',
    'uses' => 'SessionsController@store',
  ]);

  Route::get('getTokenStatus', 'SessionsController@getTokenStatus');

  Route::post('forget', [
    'as' => 'api.user.forget',
    'uses' => 'UsersController@forgotPassword',
  ]);

  Route::post('contactUs', 'UsersController@contactUs');

  Route::post('resetPassword', [
    'as' => 'api.auth.reset',
    'uses' => 'AuthController@resetPassword',
  ]);

  Route::post('register', [
    'as' => 'api.user.store',
    'uses' => 'UsersController@store'
  ]);

  Route::post('verifyRegister', [
    'as' => 'api.user.verify',
    'uses' => 'UsersController@verifyRegister'
  ]);

  Route::post('confirmLawfirm', 'UsersController@confirmLawfirm');

  Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('users', 'UsersController');
  });

  Route::get('newUsers', [
    'uses' => 'NewUsersController@getNewUsers',
    'middleware' => 'jwt.auth'
  ]);

  Route::post('approveUser', [
    'uses' => 'NewUsersController@approveUser',
    'middleware' => 'jwt.auth'
  ]);

  Route::post('dismissUser', [
    'uses' => 'NewUsersController@dismissUser',
    'middleware' => 'jwt.auth'
  ]);

  Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
    Route::resource('lawfirms', 'LawfirmsController');
  });

  Route::get('getMe', [
    'uses' => 'UsersController@getMe',
    'middleware' => 'jwt.auth'
  ]);

  Route::get('invites/getInvitesByEmail', 'v1\InvitesController@getInvitesByEmail');
  Route::get('invites/getAllInvites', 'v1\InvitesController@getAllInvites');

  Route::group(['prefix' => 'v1', 'namespace' => 'V1', 'middleware' => 'jwt.auth'], function () {
    Route::patch('updatePassword/{id}', 'UsersController@changePassword');
    Route::get('clients/getDeletedClients', 'ClientsController@getDeletedClients');
    Route::post('clients/reactivateClients', 'ClientsController@reactivateClients');
    Route::get('clients/getForms/{id}', 'ClientsController@getForms');
    Route::get('clients/getUserClients/{id}', 'ClientsController@getUserClients');
    Route::get('clients/getLawfirmClients', 'ClientsController@getLawfirmClients');
    Route::post('clients/deleteClients', 'ClientsController@deleteClients');
    Route::resource('clients', 'ClientsController');
    Route::resource('forms', 'FormsController');
    Route::post('docs/selectDocs', 'DocsController@selectDocs');
    Route::post('docs/deleteDocs', 'DocsController@deleteDocs');
    Route::get('docs/approveDismiss', 'DocsController@approveDismiss');
    Route::get('getDoc', 'DocsController@getDoc');
    Route::resource('docs', 'DocsController');
    Route::get('getProfile/{user_id}', 'ProfilesController@getProfile');
    Route::resource('profiles', 'ProfilesController');
    Route::post('users/deleteUsers', 'UsersController@deleteUsers');
    Route::resource('users', 'UsersController');
    Route::resource('clientProfiles', 'ClientProfilesController');
    Route::resource('clientApplications', 'ClientApplicationsController');
    Route::resource('clientPreparers', 'ClientPreparersController');
    Route::resource('clientRelationships', 'ClientRelationshipsController');
    Route::resource('clientSignatures', 'ClientSignaturesController');
    Route::resource('backgroundAddresses', 'BackgroundAddressesController');
    Route::resource('backgroundEmploys', 'BackgroundEmploysController');
    Route::resource('backgroundFamilies', 'BackgroundFamiliesController');
    Route::resource('backgroundSchools', 'BackgroundSchoolsController');
    Route::patch('updatePassword/{id}', 'UsersController@changePassword');
    Route::get('newUsers', 'UsersController@getNewUsers');
    Route::post('profile', [
      'as' => 'api.profile.store',
      'uses' => 'ProfilesController@store'
    ]);
    Route::get('invites/getInvites', 'InvitesController@getInvites');
    Route::resource('invites', 'InvitesController');
    Route::resource('notifications', 'NotificationsController');
    Route::get('getNotificationsByUser/{id}', 'NotificationsController@getNotificationsByUser');
    Route::get('readNotification/{id}', 'NotificationsController@readNotification');
  });
});
