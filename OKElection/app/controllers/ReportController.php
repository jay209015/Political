<?php

/**
 * Logic handling report queries
 */
class ReportController extends BaseController {

    /**
     * Get the form to lookup information about a voter by ID
     * @return mixed
     */
    public function getLookupVoter()
    {
        return View::make('lookupvoter')->with('active', 'lookupvoter');
    }

    /**
     * Process the information for the given Voter ID and display results.
     * @return mixed
     */
    public function postLookupVoter()
    {
        $voter_id      = Input::get('voter_id_num');
        $voter         = Report::getVoterByID($voter_id);
        $numTimesVoted = Report::getNumTimesVoterVoted($voter_id);

        return View::make('lookupvoterinfo')->with('voter', $voter )->with('active', 'lookupvoter')->with('numTimesVoted', $numTimesVoted);
    }

    /**
     * @return mixed Form to get County to list.
     */
    public function getUniqueVotersPerCounty()
    {
        $form['counties'] = ['options' => County::all()->toArray(), 'selected' => ''];

        return View::make('uniquevotersincounties')->with('active', 'uniquevotersincounties')
            ->with('form', $form);
    }

    /**
     * List number of voters in each precinct of each county.
     */
    public function getUniqueVotersPerCountyInfo()
    {
        $county_id    = Input::get('county_code');
        $county       = County::find($county_id);
        $uniqueVoters = Report::getNumUniqueVotersPerCounty($county->name);

        return View::make('postuniquevotersincounties')->with('active', 'uniquevotersincounties')
            ->with('county_name', $county->name)
            ->with('uniqueVoters', $uniqueVoters);
    }

    /**
     * Get the form to lookup voter counts
     * @return mixed
     */
    public function getQuery()
    {
        $form = [];
        $form['county_code'] = '';
        $form['election_dates'] = '';
        $form['appears'] = '';
        $form['affiliation'] = ['options' => array(), 'selected' => ''];
        $form['affiliation']['options']['0'] = 'All';
        $form['affiliation']['options']['DEM'] = 'Democratic';
        $form['affiliation']['options']['REP'] = 'Republican';
        $form['affiliation']['options']['IND'] = 'Independent';
        $form['counties'] = ['options' => County::all()->toArray(), 'selected' => ''];

        $count = (isset($voters))? $voters->count(): 0;
        $placeholder_date = date('Ymd');

        return View::make('report/query')
            ->with('voter', [] )
            ->with('active','queryvoter')
            ->with('form', $form)
            ->with('count', $count)
            ->with('placeholder_date', $placeholder_date);
    }


    /**
     * Process the user query and return count
     * @return mixed
     */
    public function postQuery()
    {
        $county      = Input::get('county_code');
        $dates       = explode(',', Input::get('election_dates'));
        $appears     = Input::get('appears');
        $affiliation = Input::get('affiliation');

        $form                                  = [];
        $form['county_code']                   = Input::get('county_code');
        $form['election_dates']                = Input::get('election_dates');
        $form['appears']                       = Input::get('appears');
        $form['affiliation']                   = ['options' => array(), 'selected' => Input::get('affiliation')];
        $form['affiliation']['options']['0']   = 'All';
        $form['affiliation']['options']['DEM'] = 'Democratic';
        $form['affiliation']['options']['REP'] = 'Republican';
        $form['affiliation']['options']['IND'] = 'Independent';
        $form['counties']                      = ['options' => County::all()->toArray(), 'selected' => Input::get('county_code')];

        $voters = Report::getGeneralQuery($county, $affiliation, $appears, $dates);

        $count = (isset($voters))? $voters->count(): 0;

        $placeholder_date = date('Ymd');

        return View::make('report/query')
            ->with('voters', $voters )
            ->with('active','queryvoter')
            ->with('form', $form)
            ->with('count', $count)
            ->with('placeholder_date', $placeholder_date);
    }
}