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
}