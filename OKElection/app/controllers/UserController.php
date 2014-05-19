<?php

/**
 * Logic handling Users
 */
class UserController extends BaseController {

    /**
     * Close off every page to guests except for the login page.
     */
    public function __construct() {
        $this->beforeFilter('authfacade', array('except' => ['getLoginFacade', 'postLoginFacade']));
    }

    /**
     * Form for User registration.
     * @return mixed
     */
    public function getRegister() {
        return View::make('register')->with('active', 'register');
    }

    /**
     * Validate then process User registration.
     * @return string
     */
    public function postRegister() {
        return 'Coming Soon';
    }

    /**
     * At the current time, Political report is closed for registration.
     * A temporary login is overlayed on top of the application to close
     * off registration.
     * @return mixed
     */
    public function getLoginFacade() {
        return View::make('loginfacade');
    }

    /**
     * Validate and process the temporary employee-only login.
     * @return mixed
     */
    public function postLoginFacade() {
        $remember_me = Input::get('remember_me');

        if(Auth::attempt(Input::only('email', 'password'), $remember_me)) {
            return Redirect::to('/')
                ->with('message', 'You have successfully logged in.');
        } else {
            return Redirect::back()
                ->withInput()
                ->with('error', "Invalid credentials");
        }
    }

    /**
     * The login form.
     * @return mixed
     */
    public function getLogin() {
        return View::make('login')->with('active', 'login');
    }

    /**
     * Validate and process the login form.
     * @return mixed
     */
    public function postLogin() {
        $remember_me = Input::get('remember_me');
        if(Auth::attempt(Input::only('email', 'password'), $remember_me)) {
            return Redirect::intended('/')
                ->with('message', 'You have successfully logged in.');
        } else {
            return Redirect::back()
                ->withInput()
                ->with('error', "Invalid credentials");
        }
    }

    /**
     * End the user's session and redirect them to the index.
     * @return mixed
     */
    public function getLogout() {
        Auth::logout();
        return Redirect::to('/users/login-facade')
            ->with('message', 'You are now logged out')->with('active','');
    }

    public function getProfile() {
        return View::make('profile')->with('active', '');
    }

    public function postProfile() {

    }
}