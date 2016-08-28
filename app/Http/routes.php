<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::get('confirm/{token}', 'Auth\AuthController@confirmEmail');
Route::group(['middleware' => 'web'], function ()
{

    Route::auth();
    Route::get('/', function ()
    {
        return view('pages.index');
    });
    Route::post('profile/resentConf', 'ProfileController@resentConf');
    Route::resource('profile', 'ProfileController');
    Route::resource('admin', 'AdminController');
    Route::resource('event', 'EventController');
    //Route::put('event/{event}/deadline/', 'EventDeadlineController@update');
    Route::resource('event.deadline', 'EventDeadlineController');
    Route::get('event/{event}/registration/edit', 'EventRegistrationController@edit');
    Route::get('event/{event}/registration/admin', 'EventRegistrationController@admin');
    Route::post('event/{event}/registration/exportRegistration', 'EventRegistrationController@exportRegistration');
    Route::post('event/{event}/registration/exportCategory', 'EventRegistrationController@exportCategory');
    Route::post('event/{event}/registration/importRegistration', 'EventRegistrationController@importRegistration');
    Route::get('event/{event}/registration/manage', 'EventRegistrationController@manage');
    Route::get('event/{event}/registration/manageRented', 'EventRegistrationController@manageRented');
    Route::resource('event.registration', 'EventRegistrationController');
});
