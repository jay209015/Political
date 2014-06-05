<?php

/**
 * Logic for the calendar page
 */
class CalendarController extends BaseController {

    /**
     * @return mixed render the calender.
     */
    public function getIndex()
    {
        return View::make('calendar/index')->with('active', 'calendar');
    }

    /**
     * @return mixed A JSON encoded feed of all candidates.
     */
    public function getFeed()
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

    /**
     * Get the feed for a given calendar date
     * @return string
     */
    public function getEventFeed()
    {

        // Pull in the requested dates
        $get_start = Input::get('start');

        // Convert them to mysql dates
        $mysql_date = date('Y-m-d', $get_start);


        $candidates = Calendar::getElectionCandidates($mysql_date);


        return '<textarea rows="16" cols="100">'.json_encode(array_values($candidates)).'</textarea>';
    }
}