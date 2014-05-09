<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index')->with('active', 'index');
});

Route::get('/register', function()
{
    return View::make('register')->with('active', 'register');
});

Route::post('/register', function(){
    return 'Coming Soon';
});

Route::get('/login', function()
{
    return View::make('login')->with('active', 'login');
});

Route::post('/login', function(){
    /*if(Auth::attempt(Input::only('email', 'password'))) {
        return Redirect::intended('/');
    } else {
        return Redirect::back()
            ->withInput()
            ->with('error', "Invalid credentials");
    }*/
    return 'Coming Soon';
});

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/')
        ->with('message', 'You are now logged out');
});
