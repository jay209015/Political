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
        //$get_start = Input::get('start');
        //$get_end = Input::get('end');
        $candidates = Candidate::all();/*where('prim_or_runoff_date', '>=', $get_start)
        ->where('prim_or_runoff_date', '<=', $get_end);*/
        $output = [];
        $set    = [];

        for($i = 0; $i < count($candidates); ++$i) {
            //$output[$i]['title'] = $candidates[$i]->first_name . ' ' . $candidates[$i]->last_name;
            //$output[$i]['start'] = strtotime($candidates[$i]->prim_or_runoff_date);
            //$output[$i]['end'] = strtotime($candidates[$i]->prim_or_runoff_date);
            $set[] = strtotime($candidates[$i]->prim_or_runoff_date);
        }
        //remove duplicates then reset key values back to 0
        $set = array_values(array_unique($set));

        for($i = 0; $i < count($set); ++$i) {
            $output[$i]['title'] = '#Events';
            $output[$i]['start'] = $set[$i];
        }

        $json = json_encode($output, JSON_UNESCAPED_SLASHES);
        return $json;

    }

    public function getEventFeed()
    {
        $start = Input::get('start');
        $end = Input::get('end');

        $candidates = Candidate::all();
        $output = [];
        for ($i = 0; $i < count($candidates); ++$i) {
            $unix_time = strtotime($candidates[$i]->prim_or_runoff_date);
            if ($unix_time == $start) {
                $output[$i] = $candidates[$i]->first_name . ' ' . $candidates[$i]->last_name;
            }
        }
        return '<textarea rows="16" cols="100">'.json_encode(array_values($output)).'</textarea>';
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