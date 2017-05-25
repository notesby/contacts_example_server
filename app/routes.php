<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

/*---------------------------- Contact ----------------------------*/
Route::post('/contact/insert', array('before' => '', 'uses' => 'ContactController@Insert'));
Route::post('/contact/update', array('before' => '', 'uses' => 'ContactController@Update'));
Route::post('/contact/delete', array('before' => '', 'uses' => 'ContactController@Delete'));
Route::post('/contact/get', array('before' => '', 'uses' => 'ContactController@Get'));
Route::get('/contact/get/all', array('before' => '', 'uses' => 'ContactController@GetAll'));