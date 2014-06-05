<?php

/**
 * Stores all query logic to the database for reports.
 *
 * @author   Andre Patterson <apatterson@printplace.com>
 */
class Report {

    public function __construct()
    {
        //Todo
    }

    /**
     * @param $county_name The name of the county
     * @return mixed The number of unique votes per precinct in this particular county.
     */
    public static function getNumUniqueVotersPerCounty($county_id)
    {
        $per_page = 20;
        $page = Input::get('page');

        $votes_per_county = County::select(array(
                'voters.precinct_number as precinct_number',
                DB::raw('COUNT(*) as `count`'),
                'counties.name as county_name'
            ))
            ->join('voters', 'voters.county', '=', 'counties.id')
            ->where('counties.id', '=', DB::raw($county_id))
            ->where('voters.county', '=', DB::raw($county_id))
            ->groupBy('voters.precinct_number')
            ->paginate($per_page);

        return $votes_per_county;
    }

    public static function getVoterTotal()
    {
        $total = DB::table('voters')
            ->count();

        return $total;
    }


    public static function getVoterByID($id)
    {
        $voter = Voter::where('voter_id_num', '=', $id)->firstOrFail();

        return $voter;
    }

    /**
     * Returns a count of the number of times a voter voted in all elections.
     * @param $id The ID of the voter whose votes we want to count
     * @return mixed
     */
    public static function getNumTimesVoterVoted($id)
    {
        $num_votes = DB::table('voters')
            ->join('histories', 'voters.voter_id_num', '=', 'histories.voter_id_num')
            ->where('voters.voter_id_num', '=', $id)
            ->count();

        return $num_votes;
    }

    /**
     *
     * @param $county
     * @param $affiliation
     * @param $appears
     * @param $dates
     */
    public static function getGeneralQuery($county, $affiliation, $appears, $dates)
    {
        $query = Voter::select(array('voters.voter_id_num', DB::raw('COUNT(*) as `count`')));
        $query->join('histories', 'histories.voter_id_num', '=', 'voters.voter_id_num');

        if($county){
            $query->where('county', '=', $county);
        }

        if($affiliation){
            $query->where('political_affiliation', '=', $affiliation);
        }

        if(isset($dates) && is_array($dates) && $dates[0]){
            $query->wherein('election_date', $dates);
        }

        if($appears){
            $count = min($appears, count($dates));
            $query->having('count', '=', $count);
        }

        $query->groupBy('voters.voter_id_num');

        $voters = $query->get();

        return $voters;

        /*
        $queries = DB::getQueryLog();
        $last_query = end($queries);

        print_r($queries);
        exit();
        */
    }
}