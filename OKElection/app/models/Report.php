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
     * Returns the number of people that have the same mailing address as the voter in question.
     * @param $voter_id
     * @return int the number of household members corresponding to $voter_id
     */
    public static function getNumHouseholdMembers($voter_id)
    {
        $voter = Report::getVoterByID($voter_id);
        $numHouseholds = DB::table('voters')
            ->where('mailing_street_address_1', '=', $voter->mailing_street_address_1)
            ->where('zip_code', '=', $voter->zip_code)
            ->count();
        return $numHouseholds;
    }

    /**
     * @param $county_id The unique county identifier
     * @return mixed The number of unique votes per precinct in this particular county.
     */
    public static function getNumUniqueVotersPerCounty($county_id, $database)
    {
        $per_page = 20;
        $page = Input::get('page');

        $votes_per_county = County::on($database)->select(array(
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

    /**
     * @return mixed the total number of voters in the database
     */
    public static function getVoterTotal()
    {
        $total = DB::table('voters')
            ->count();

        return $total;
    }


    /**
     * @param $id
     * @return mixed a voter object
     */
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
     * Get an array of query fields for the query tool
     * @return array
     */
    public static function getQueryFields(){
        $counties = County::all()->toArray();

        $county_fields = array();
        foreach($counties as $county){
            $county['value'] = $county['id'];
            $county_fields[] = $county;
        }

        $fields = array();
        $fields[] = new QueryField(
            'county',
            $county_fields,
            $county_fields[0],
            'County'
        );


        $election_dates = Calendar::getElectionDates();
        $election_date_fields = array();
        foreach($election_dates as $election_date){
            if(date('m/d/Y', $election_date['start']) == '01/01/1970'){
                continue;
            }
            $election_date['name'] = date('m/d/Y', $election_date['start']);
            $election_date['value'] = date('Ymd', $election_date['start']);
            $election_date_fields[] = $election_date;
        }
        $fields[] = new QueryField(
            'election_date',
            $election_date_fields,
            $election_date_fields[0],
            'Election Date'
        );

        $affiliation_fields = array(
            array(
                'name' => 'Democratic',
                'value' => 'DEM'
            ),
            array(
                'name' => 'Republican',
                'value' => 'REP'
            ),
            array(
                'name' => 'Independent',
                'value' => 'IND'
            )
        );
        $fields[] = new QueryField(
            'political_affiliation',
            $affiliation_fields,
            $affiliation_fields[0],
            'Political Affiliation'
        );

        return $fields;
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