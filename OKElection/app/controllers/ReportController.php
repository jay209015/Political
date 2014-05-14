<?php

/**
 * Logic handling report queries
 */
class ReportController extends BaseController {

    public function getLookupVoter() {
        return View::make('lookupvoter')->with('active', 'lookupvoter');
    }

    public function postLookupVoter() {
        $voter = Voter::where('voter_id_num', '=', Input::get('voter_id_num'))->firstOrFail();
        //$total = DB::table('voters')->count();
        return View::make('lookupvoterinfo')->with('voter', $voter )->with('active', 'lookupvoter');
    }

    public function getQuery(){
        return View::make('report/query')->with('voter', [] )->with('active','queryvoter');
    }

    public function postQuery(){
        /*
         * SELECT
	COUNT(DISTINCT voters.voter_id_num)
FROM
	voters
RIGHT JOIN histories ON histories.voter_id_num = voters.voter_id_num
WHERE
	precinct_number LIKE "17%"
AND
	histories.election_date IN (
		'20140401',
		'20140211',
		'20131112',
		'20130402'
	)
         */

        $county = Input::get('county_code');
        $dates = Input::get('election_dates');
        $appears = Input::get('appears');
        $voters = array();

        $query = Voter::where('precinct_number', 'like', $county."%");

        if($dates){
            $query->whereHas('histories', function($q) use($dates){
                $q->wherein('election_date', explode(',', $dates));
            });
        }


        $voters = $query->get();


        return View::make('report/query')->with('voters', $voters )->with('active','queryvoter');
    }
}