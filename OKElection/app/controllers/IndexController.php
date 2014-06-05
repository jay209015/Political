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
     * @return mixed render the calender.
     */
    public function getCalendar()
    {
        return View::make('calendar')->with('active', 'calendar');
    }

    /**
     * @return mixed A JSON encoded feed of all candidates.
     */
    public function getCalendarFeed()
    {

        // Pull in the requested dates
        $get_start = Input::get('start');
        $get_end = Input::get('end');

        // Convert them to mysql dates
        $mysql_start = date('Y-m-d', $get_start);
        $mysql_end = date('Y-m-d', $get_end);

        $events = Calendar::getElectionDates($mysql_start, $mysql_end);

        // Output JSON
        $json = json_encode($events, JSON_UNESCAPED_SLASHES);
        return $json;

    }

    public function getEventFeed()
    {

        // Pull in the requested dates
        $get_start = Input::get('start');

        // Convert them to mysql dates
        $mysql_date = date('Y-m-d', $get_start);


        $candidates = Calendar::getElectionCandidates($mysql_date);


        return '<textarea rows="16" cols="100">'.json_encode(array_values($candidates)).'</textarea>';
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