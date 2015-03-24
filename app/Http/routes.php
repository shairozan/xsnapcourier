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

Route::group(['middleware'=>'adauth'],function(){
	Route::resource('volumes','VolumeController');
	Route::resource('snapshots','SnapshotController');
	Route::get('snapshots/delete/{id}','SnapshotController@destroy');
	Route::resource('datatypes','DataTypesController');
	Route::get('/disable', 'SnapshotController@disableSchedule');
	Route::get('/enable','SnapshotController@enableSchedule');
	Route::get('/', 'DashboardController@index');
	Route::get('/logout','UsersController@logoutAction');
	Route::get('/volumes/snap/{id}','SnapshotController@manualSnapshot');
});

Route::get('process/snaps','SnapshotController@processSchedule');
Route::get('process/stats','StatisticsController@processStatistics');





Route::get('/login','UsersController@displayLogin');
Route::post('/dologin','UsersController@loginAction');

// Route::get('test',function(){
// 	\App\Volume::syncVolumes();
// });

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
