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
        return View::make('report/lookupvoter')->with('active', 'lookupvoter');
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
        $numHouseholdMembers = Report::getNumHouseholdMembers($voter_id);

        return View::make('report/lookupvoterinfo')->with('voter', $voter )
            ->with('active', 'lookupvoter')
            ->with('numTimesVoted', $numTimesVoted)
            ->with('numHouseholdMembers', $numHouseholdMembers);
    }

    /**
     * @return mixed Form to get County to list.
     */
    public function getUniqueVotersPerCounty()
    {
        $form['counties'] = ['options' => County::all()->toArray(), 'selected' => ''];

        return View::make('report/uniquevotersincounties')->with('active', 'uniquevotersincounties')
            ->with('form', $form);
    }

    /**
     * List number of voters in each precinct of each county.
     */
    public function getUniqueVotersPerCountyInfo()
    {
        $county_id    = Input::get('county_code');
        $state        = Input::get('state');
        switch($state) {
            case "0":
                $state = 'mysql';
                break;
            case "1":
                $state = 'mysql2';
                break;
            default:
                $state = 'mysql';
        }
        $county       = County::on($state)->find($county_id);
        $uniqueVoters = Report::getNumUniqueVotersPerCounty($county_id, $state);

        return View::make('report/postuniquevotersincounties')->with('active', 'uniquevotersincounties')
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
        $fields = Report::getQueryFields();
        $comparisons = Report::getQueryComparisons();


        $count = (isset($voters))? $voters->count(): 0;
        $placeholder_date = date('Ymd');

        return View::make('report/query')
            ->with('voter', [] )
            ->with('active','queryvoter')
            ->with('form', $form)
            ->with('fields', $fields)
            ->with('comparisons', $comparisons)
            ->with('count', $count)
            ->with('placeholder_date', $placeholder_date);
    }

    /**
     * Process the user query and return count
     * @return mixed
     */
    public function postQuery()
    {
        $query = base64_decode(Input::get('q'));

        $parsed = array();
        $groups = explode(')', $query);

        foreach($groups as $group){
            $split = explode('(', $group);
            foreach($split as $part){
                if(trim($part)){
                    $parsed[] = trim($part);
                }
            }
        }

        $comparisons = Report::getQueryComparisons();
        $comparison_search = array();
        foreach($comparisons as $comparator){
            $comparison_search[] = $comparator['display'];
        }
        foreach($parsed as $key => $part){
            if(strlen($part) > 3){
               $part = str_replace('AND', '|AND|', $part);
               $part = str_replace('OR', '|OR|', $part);
               $group_parts = explode('|', $part);

                foreach($group_parts as $k => $v){
                    $v = trim($v);
                    if(strlen($v) > 3){
                        foreach($comparisons as $comparator){
                            $v = str_replace(" {$comparator['value']} ", "|{$comparator['value']}|", $v);
                            $v = str_replace('[','(', $v);
                            $v = str_replace(']',')', $v);
                        }
                        $v = explode('|', $v);
                    }
                    $group_parts[$k] = $v;
                }

               $parsed[$key] = $group_parts;
            }
        }

        $query = Voter::select(array('voters.voter_id_num', DB::raw('COUNT(*) as `count`')));
        $query->join('histories', 'histories.voter_id_num', '=', 'voters.voter_id_num');

        $operator = 'AND';
        foreach($parsed as $group){
            if(strtolower($operator) == 'or'){
                $method = 'orWhere';
            }else{
                $method = 'where';
            }

            if(is_array($group)){
                $query->$method(function($query) use($group) {
                    $sub_operator = 'AND';
                    foreach($group as $field){
                        if(is_array($field)){
                            if(strtolower($sub_operator) == 'or'){
                                $sub_method = 'orWhere';
                            }else{
                                $sub_method = 'where';
                            }
                            $column = $field[0];
                            $comparator = $field[1];
                            $value = $field[2];

                            if($comparator == 'IN'){
                                $query->$sub_method(function($query) use($column, $value){
                                    $values = str_replace(array('(',')'), '', $value);
                                    $query->whereIn($column, explode(',', $values));
                                });
                            }else{
                                $query->$sub_method($column, $comparator, $value);
                            }
                        }else{
                            $sub_operator = $field;
                        }
                    }
                });
            }else{
                $operator = $group;
            }
        }

        $query->groupBy('voters.voter_id_num');

        $voters = $query->get();

        echo number_format($voters->count(), 0);
    }
}