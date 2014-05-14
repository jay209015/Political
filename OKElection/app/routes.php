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

Route::group(array('before' => 'authfacade'), function() {
Route::get('/', function()
{
    if(Auth::check()){
        return View::make('index')->with('active', 'index');
    } else {
        return Redirect::to('login');
    }

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
    if(Auth::attempt(Input::only('email', 'password'))) {
        return Redirect::intended('/')
            ->with('message', 'You have successfully logged in.');
    } else {
        return Redirect::back()
            ->withInput()
            ->with('error', "Invalid credentials");
    }
});

Route::get('/about', function()
{
    return View::make('about')->with('active', 'about');
});

Route::get('/contact', function()
{
    return View::make('contact')->with('active', 'contact');
});

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/')
        ->with('message', 'You are now logged out')->with('active','');
});

Route::get('/lookupvoter', function()
{
    return View::make('lookupvoter')->with('active', 'lookupvoter');
});

Route::post('/lookupvoter', function()
{
    $voter = Voter::where('voter_id_num', '=', Input::get('voter_id_num'))->firstOrFail();
    //$total = DB::table('voters')->count();
    return View::make('lookupvoterinfo')->with('voter', $voter )->with('active', 'lookupvoter');
});
});

Route::get('/loginfacade', function()
{
    return View::make('loginfacade');
});

Route::post('/loginfacade', function(){
    if(Auth::attempt(Input::only('email', 'password'))) {
        return Redirect::intended('/')
            ->with('message', 'You have successfully logged in.');
    } else {
        return Redirect::back()
            ->withInput()
            ->with('error', "Invalid credentials");
    }
});
