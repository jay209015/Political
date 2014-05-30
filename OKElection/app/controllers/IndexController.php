<?php

/**
 * Logic for the root page
 */
class IndexController extends BaseController {

    /**
     * Render the homepage if logged in.
     */
    public function getIndex() {
        if(Auth::check()){
            return View::make('index')->with('active', 'index');
        } else {
            return Redirect::to('users/login-facade');
        }
    }

    /**
     * @return mixed render the calender.
     */
    public function getCalendar() {
        return View::make('calendar')->with('active', 'calendar');
    }

    /**
     * @return mixed A JSON encoded feed of all candidates.
     */
    public function getCalendarFeed()
    {
        //$get_start = Input::get('start');
        //$get_end = Input::get('end');
        $candidates = Candidate::all()->take(10);/*where('prim_or_runoff_date', '>=', $get_start)
        ->where('prim_or_runoff_date', '<=', $get_end);*/
        $output = [];

        for($i = 0; $i < count($candidates); ++$i) {
            $output[$i]['title'] = $candidates[$i]->first_name . ' ' . $candidates[$i]->last_name;
            $output[$i]['start'] = strtotime($candidates[$i]->prim_or_runoff_date);
            //$output[$i]['end'] = strtotime($candidates[$i]->prim_or_runoff_date);
        }

        $json = json_encode($output, JSON_UNESCAPED_SLASHES);
        return $json;

    }

    /**
     * Render the About Us page.
     * @return mixed
     */
    public function getAbout() {
        return View::make('about')->with('active', 'about');
    }

    /**
     * Render the company contact information page.
     * @return mixed
     */
    public function getContact() {
        return View::make('contact')->with('active', 'contact');
    }
}