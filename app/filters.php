<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
	//Log::info(Request::header());
	//Log::info(Request::all());
});


App::after(function($request, $response)
{
	//
});

App::error(function(Exception $exception, $code)
{
	$errorClass = get_class($exception);
	if ($errorClass == "PDOException")
	{
		if($exception->getCode() == 2002)
		{
			Log::error($exception);
			if (Request::ajax())
			{
				return array('error'=>true,'message'=>'Cannot connect to database.','data'=>'');
			}
			else
			{
				return Redirect::to('error')->with('error','Cannot connect to database.');
			}
		}
	}
	if ($errorClass == "Illuminate\Database\QueryException")
	{
		if($exception->getCode() == 23000)
		{
			if($exception->errorInfo[1] == 1451)
			if (Request::ajax())
			{
				return array('error'=>true,'message'=>'Cannot delete registry'.
					' for integrity reasons (there are refereneces to this data).','data'=>'');
			}
			else
			{
				return Redirect::to('error')->with('error','Cannot delete registry'.
					' for integrity reasons (there are refereneces to this data).');
			}
		}
	}
    switch ($code)
    {
        case 404:
            if (Request::ajax())
			{
				return array('error'=>true,'message'=>'Route not found.','data'=>'');
			}
			else
			{
				return Redirect::to('/404');
			}
        default:
        	Log::info(Request::url());
        	Log::error($exception);
            if (Request::ajax())
			{
				return array('error'=>true,'message'=>'Petition error, check the log.','data'=>'');
			}
			else
			{
				return Redirect::to('error');
			}
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('mobile', function()
{
	$user = Auth::user();
	if(!$user)
	{
		if (Request::ajax())
		{
			return array('error'=>true,'message'=>Lang::get('messages.unauthorized'),'data'=>'');
		}
		else
		{
			return array('error'=>true,'message'=>Lang::get('messages.unauthorized'),'data'=>'');
			//return Redirect::to('error')->with('error',Lang::get('messages.unauthorized'));
		}
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
