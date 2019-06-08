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

//Tutorial Routes (maybe useful)
Route::get('/', 'PageController@index');
Route::view('/welcome', 'welcome');

//Templates
Route::get('/template', function(){return view('templates.index');});

//Resource Routes
//Employee routes
Route::get('/employee/deactivated', 'employeeController@showDeactivated');
Route::resource('/employee', 'employeeController');
Route::get('/employee/{employee}/deactivate', 'employeeController@deactivate');
Route::get('/employee/{employee}/activate', 'employeeController@activate');
Route::get('/running', 'logController@index');

//Project routes
Route::get('/project/all', 'projectController@all');
Route::get('/project/past', 'projectController@past');
Route::resource('/project', 'projectController');


Route::resource('/client', 'Resources\clientController');


Route::put('/log/store','logController@store')->name('log.store');
Route::get('/log/edit','logController@edit')->name('log.edit');
Route::post('/log/update','logController@update')->name('log.update');
Route::get('/log/{id}','logController@end')->name('log.end');
Route::delete('/log/destroy','logController@destroy')->name('log.destroy');


Route::get('/confirm/{project}/{task}/{transponder}','logController@confirm')->name('log.confirm');


Route::resource('/project/{project}/task', 'taskController')->except([
    'index'
]);
Route::get('/project/{project}/deactivate', 'projectController@deactivate');
Route::get('/project/{project}/reactivate', 'projectController@reactivate');
Route::resource('/user', 'userController')->only('index','destroy','edit','update');

Auth::routes();