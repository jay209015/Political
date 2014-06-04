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

        // Get all the prim_or_runoff_dates
        $prim_dates = DB::table('candidates')
            ->select(DB::raw("'Event(s)' as `title`, UNIX_TIMESTAMP(`prim_or_runoff_date`) as `start`"))
            ->where('prim_or_runoff_date', '>=', $mysql_start)
            ->where('prim_or_runoff_date', '<=', $mysql_end);


        // Union with the elec_dates
        $elec_dates = Candidate::select(DB::raw("'Event(s)' as `title`, UNIX_TIMESTAMP(`elec_date`) as `start`"))
            ->where('elec_date', '>=', $mysql_start)
            ->where('elec_date', '<=', $mysql_end)
            ->union($prim_dates)
            ->get()
            ->toArray();


        // Output JSON
        $json = json_encode($elec_dates, JSON_UNESCAPED_SLASHES);
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