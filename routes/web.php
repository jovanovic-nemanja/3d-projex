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

Auth::routes();

Route::get('/home', 'Frontend\HomeController@index')->name('home');


Route::get('/', 'Frontend\HomeController@index')->name('home');


Route::get('/admin', 'Admin\GeneralSettingsController@index')->name('dashboard.index');


Route::get('/admin/general', 'Admin\GeneralSettingsController@index')->name('admin.generalsetting');
Route::put('/admin/general/update/{generalsetting}', 'Admin\GeneralSettingsController@update')->name('admin.generalsetting.update');


Route::get('/admin/localization', 'Admin\LocalizationSettingsController@index')->name('admin.localizationsetting');
Route::put('/admin/localization/update/{localizationsetting}', 'Admin\LocalizationSettingsController@update')->name('admin.localizationsetting.update');



Route::resource('admin/users', 'Admin\UsersController');
Route::get('/admin/users', 'Admin\UsersController@index')->name('users.index');
Route::get('/users/resetpwd/{token}', 'Admin\UsersController@resetpwd')->name('users.resetpwd');
Route::POST('/users/resetUserpassword', 'Admin\UsersController@resetUserpassword')->name('users.resetUserpassword');


Route::get('/account', 'Frontend\AccountController@index')->name('account');
Route::get('/changepass', 'Frontend\AccountController@changepass')->name('changepass');
Route::put('/account/update', 'Frontend\AccountController@update')->name('account.update');
Route::put('/account/updatePassword', 'Frontend\AccountController@updatePassword')->name('account.updatePassword');




Route::resource('admin/models', 'Admin\ModelsController');
Route::get('/admin/models', 'Admin\ModelsController@index')->name('models.index');


Route::resource('admin/wallpapers', 'Admin\WallpapersController');
Route::get('/admin/wallpapers', 'Admin\WallpapersController@index')->name('wallpapers.index');
Route::POST('/admin/wallpapers/storage', 'Admin\WallpapersController@storage')->name('wallpapers.storage');



// paypal
Route::get('/paymentrequest', 'PaymentController@index');
// route for processing payment
Route::post('paymentrequest', 'PaymentController@payWithpaypal');
Route::post('paymentngeniusrequest', 'PaymentController@paymentngeniusrequest');
// route for check status of the payment
Route::get('paymentstatus', 'PaymentController@getPaymentStatus');


Route::post('/savecheckout', 'Admin\OrderlistController@Savecheckout');


Route::resource('admin/orderlists', 'Admin\OrderlistController');
Route::get('/admin/orderlists', 'Admin\OrderlistController@index')->name('orderlists.index');