<?php

/**
 * Logic handling report queries
 */
class ReportController extends BaseController {

    /**
     * Get the form to lookup information about a voter by ID
     * @return mixed
     */
    public function getLookupVoter() {
        return View::make('lookupvoter')->with('active', 'lookupvoter');
    }

    /**
     * Process the information for the given Voter ID and display results.
     * @return mixed
     */
    public function postLookupVoter() {
        $voter = Voter::where('voter_id_num', '=', Input::get('voter_id_num'))->firstOrFail();
        //$total = DB::table('voters')->count();
        return View::make('lookupvoterinfo')->with('voter', $voter )->with('active', 'lookupvoter');
    }

    public function getQuery(){
        $form = [];
        $form['county_code'] = '';
        $form['election_dates'] = '';
        $form['appears'] = '';

        return View::make('report/query')->with('voter', [] )->with('active','queryvoter')->with('form', $form);
    }

    public function postQuery(){

        $county = Input::get('county_code');
        $dates = explode(',', Input::get('election_dates'));
        $appears = Input::get('appears');

        $form = [];
        $form['county_code'] = Input::get('county_code');
        $form['election_dates'] = Input::get('election_dates');
        $form['appears'] = Input::get('appears');

        $query = Voter::select(array('voters.voter_id_num', DB::raw('COUNT(*) as `count`')));;

        if($county){
            $query->where('county', '=', $county);
        }

        if($dates){
            $query->join('histories', 'histories.voter_id_num', '=', 'voters.voter_id_num');
            $query->wherein('election_date', $dates);
        }

        if($appears){
            $count = min($appears, count($dates));
            $query->having('count', '=', $count);
        }

        $query->groupBy('voters.voter_id_num');


        $voters = $query->get();


        return View::make('report/query')->with('voters', $voters )->with('active','queryvoter')->with('form', $form);
    }
}