<?php

/**
 * Stores all query logic to the database for calendars.
 *
 * @author    Jay Rivers <jrivers@printplace.com>
 */
class Calendar {

    public function __construct()
    {
        //Todo
    }

    /**
     * Get an array of election dates based on time range
     * @param $mysql_start
     * @param $mysql_end
     * @return array
     */
    public static function getElectionDates($mysql_start, $mysql_end){
        // Get all the prim_or_runoff_dates
        $prim_dates = DB::table('candidates')
            ->select(DB::raw("CONCAT(COUNT(*), ' Event(s)') as `title`, UNIX_TIMESTAMP(`prim_or_runoff_date`) as `start`"))
            ->where('prim_or_runoff_date', '>=', $mysql_start)
            ->where('prim_or_runoff_date', '<=', $mysql_end)
            ->groupBy('prim_or_runoff_date');


        // Union with the elec_dates
        $elec_dates = Candidate::select(DB::raw("CONCAT(COUNT(*), ' Event(s)') as `title`, UNIX_TIMESTAMP(`elec_date`) as `start`"))
            ->where('elec_date', '>=', $mysql_start)
            ->where('elec_date', '<=', $mysql_end)
            ->groupBy('elec_date')
            ->union($prim_dates)
            ->get()
            ->toArray();

        return $elec_dates;
    }

    /**
     * Get an array of candidates for a given election date
     * @param $mysql_date
     * @return mixed
     */
    public static function getElectionCandidates($mysql_date){
        $candidates = Candidate::select('first_name', 'last_name')
            ->where('prim_or_runoff_date', '=', $mysql_date)
            ->orWhere('elec_date', '=', $mysql_date)
            ->get()
            ->toArray();

        return $candidates;
    }
}