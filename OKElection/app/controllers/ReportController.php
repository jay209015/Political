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
}