<?php

/**
 * Stores all query logic to the database for reports.
 *
 * @author   Jay Rivers <jayrivers@printplace.com>
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

    public static function getQueryComparisons(){
        $comparisons = array();
        $comparisons[] = array(
            'display' => 'is',
            'value' => '='
        );
        $comparisons[] = array(
            'display' => 'is not',
            'value' => '<>'
        );
        $comparisons[] = array(
            'display' => 'is greater than',
            'value' => '>'
        );
        $comparisons[] = array(
            'display' => 'is greater than or equal to',
            'value' => '>='
        );
        $comparisons[] = array(
            'display' => 'is less than',
            'value' => '<'
        );
        $comparisons[] = array(
            'display' => 'is less than or equal to',
            'value' => '<='
        );
        $comparisons[] = array(
            'display' => 'is any of these',
            'value' => 'IS:IN'
        );
        $comparisons[] = array(
            'display' => 'is none of these',
            'value' => 'NOT:IN'
        );
        $comparisons[] = array(
            'display' => 'is all of these',
            'value' => 'IN:ALL'
        );

        return $comparisons;
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
            $county_fields[0]['value'],
            'County'
        );


        $election_dates = Election::orderBy('election_date', 'ASC')->get();
        $election_date_fields = array();
        foreach($election_dates as $election_date){
            $field = array();
            $field['name'] = date('m/d/Y', strtotime($election_date->election_date));
            $field['value'] = str_replace('-', '', $election_date->election_date);
            $election_date_fields[] = $field;
        }
        $fields[] = new QueryField(
            'election_date',
            $election_date_fields,
            $election_date_fields[0]['value'],
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
            $affiliation_fields[0]['value'],
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

    public static function parseQuery($query_string){
        $parsed = array();
        $groups = explode(')', $query_string);

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

        return $parsed;
    }

    public static function buildQuery($parsed_query, $id_only=false){
        if($id_only){
            $query = Voter::select(array('voters.voter_id_num'));
        }else{
            $query = Voter::select(array('voters.voter_id_num', DB::raw('COUNT(*) as `count`')));
        }

        $query->join('histories', 'histories.voter_id_num', '=', 'voters.voter_id_num');

        $operator = 'AND';
        foreach($parsed_query as $group){
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

                            if($comparator == 'IS:IN'){
                                $query->$sub_method(function($query) use($column, $value){
                                    $values = str_replace(array('(',')'), '', $value);
                                    $query->whereIn($column, explode(',', $values));
                                });
                            }elseif($comparator == 'NOT:IN'){
                                $query->$sub_method(function($query) use($column, $value){
                                    $values = str_replace(array('(',')'), '', $value);
                                    $query->whereNotIn($column, explode(',', $values));
                                });
                            }elseif($comparator == 'IN:ALL'){
                                $query->$sub_method(function($query) use($column, $value){
                                    $values = explode(',',str_replace(array('(',')'), '', $value));
                                    foreach($values as $value){
                                        $query->where($column, $value);
                                    }
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
        return $query;
    }

    public static function getListFields(){
        $fields = array();
        $fields[] = array(
            'display' => 'Full Name',
            'value' => 'full_name',
            'required' => true
        );
        $fields[] = array(
            'display' => 'Prefix',
            'value' => 'prefix',
            'required' => false
        );
        $fields[] = array(
            'display' => 'First Name',
            'value' => 'first_name',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Middle Name',
            'value' => 'middle_name',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Last Name',
            'value' => 'last_name',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Suffix',
            'value' => 'suffix',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Company',
            'value' => 'company',
            'required' => true
        );
        $fields[] = array(
            'display' => 'Address Line 1',
            'value' => 'address_1',
            'required' => true
        );
        $fields[] = array(
            'display' => 'Address Line 2',
            'value' => 'address_2',
            'required' => true
        );
        $fields[] = array(
            'display' => 'City',
            'value' => 'city',
            'required' => true
        );
        $fields[] = array(
            'display' => 'State',
            'value' => 'state',
            'required' => true
        );
        $fields[] = array(
            'display' => 'Zip',
            'value' => 'zip',
            'required' => true
        );

        $fields[] = array(
            'display' => 'CRRT',
            'value' => 'crrt',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Walk Sequence',
            'value' => 'walk_sequence',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Phone',
            'value' => 'phone',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Email',
            'value' => 'email',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Account Number',
            'value' => 'account_number',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Custom 1',
            'value' => 'custom_1',
            'required' => false
        );
        $fields[] = array(
            'display' => 'Custom 2',
            'value' => 'custom_2',
            'required' => false
        );

        return $fields;
    }

    public static function mapCsv($file, $has_header, $mapping, $exclusions = array()){
        $fields = Report::getListFields();
        $data = array();
        $csv = "";
        $header = false;
        $index = 0;
        $out = array();

        $out_row = array();
        foreach($fields as $key => $field){
            $out_row[] = $field['display'];
        }
        $out[] = $out_row;

        if (($handle = fopen($file, 'r')) !== false){
            while (($row = fgetcsv($handle, 1000, ',')) !== false){
                if(!$header && $has_header){
                    $header = true;
                }else{
                    foreach($row as $column => $value){
                        if(!in_array($column, $exclusions)){
                            $data[$index][$mapping[$column]] = $value;
                        }
                    }
                    ksort($data[$index]);
                    $index++;
                }
            }
            fclose($handle);
        }

        $total_rows = count($data);
        $current_row = 0;


        while($current_row < $total_rows){
            $out_row = array();
            foreach($fields as $key => $field){
                if(isset($data[$current_row][$key])){
                    $out_row[] = $data[$current_row][$key];
                }else{
                    $out_row[] = "";
                }
            }
            $out[] = $out_row;
            $current_row++;
        }

        return $out;
    }
}