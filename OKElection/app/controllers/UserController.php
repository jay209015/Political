<?php

/**
 * Logic handling Users
 */
class UserController extends BaseController {

    public function __construct() {
        $this->beforeFilter('authfacade', array('except' => ['getLoginFacade', 'postLoginFacade']));
    }

    public function getRegister() {
        return View::make('register')->with('active', 'register');
    }

    public function postRegister() {
        return 'Coming Soon';
    }

    public function getLoginFacade() {
        return View::make('loginfacade');
    }

    public function postLoginFacade() {
        if(Auth::attempt(Input::only('email', 'password'))) {
            return Redirect::to('/')
                ->with('message', 'You have successfully logged in.');
        } else {
            return Redirect::back()
                ->withInput()
                ->with('error', "Invalid credentials");
        }
    }

    public function getLogin() {
        return View::make('login')->with('active', 'login');
    }

    public function postLogin() {
        if(Auth::attempt(Input::only('email', 'password'))) {
            return Redirect::intended('/')
                ->with('message', 'You have successfully logged in.');
        } else {
            return Redirect::back()
                ->withInput()
                ->with('error', "Invalid credentials");
        }
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::to('/')
            ->with('message', 'You are now logged out')->with('active','');
    }
}