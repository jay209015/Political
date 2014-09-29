<?php

/**
 * Logic for the root page
 */
class IndexController extends BaseController {

    /**
     * Render the homepage if logged in.
     */
    public function getIndex()
    {
        if(Auth::check()){
            return View::make('index')->with('active', 'index');
        } else {
            return Redirect::to('users/login-facade');
        }
    }


    /**
     * Render the About Us page.
     * @return mixed
     */
    public function getAbout()
    {
        return View::make('about')->with('active', 'about');
    }

    /**
     * Render the company contact information page.
     * @return mixed
     */
    public function getContact()
    {
        return View::make('contact')->with('active', 'contact');
    }
}