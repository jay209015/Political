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
        $query_string = base64_decode(Input::get('q'));
        $parsed = Report::parseQuery($query_string);
        $query = Report::buildQuery($parsed);
        $voters = $query->get();

        /*
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        print_r($last_query);
        */

        echo number_format($voters->count(), 0);
    }

    public function postExportQuery(){
        $query_string = base64_decode(Input::get('q'));
        $parsed = Report::parseQuery($query_string);
        $query = Report::buildQuery($parsed, true);
        $results = $query->get()->toArray();

        $voter_ids = array();
        foreach($results as $result){
            $voter_ids[] = $result['voter_id_num'];
        }

        $csv_data = array();


        $voters = Voter::select(
                'first_name',
                'last_name',
                'mailing_street_address_1',
                'mailing_street_address_2',
                'mailing_address_city',
                'mailing_address_state',
                'mailing_address_zip_code'
            )
            ->whereIn('voter_id_num', $voter_ids)
            ->get()
            ->toArray();

        $headers = array(
            'First Name',
            'Last Name',
            'Mailing Street Address 1',
            'Mailing Street Address 2',
            'Mailing Address City',
            'Mailing Address State',
            'Mailing Address Zip Code'
        );

        array_push($csv_data, $headers);

        foreach($voters as $voter){
            array_push($csv_data, array_values($voter));
        }

        $path = public_path('downloads');
        $file = date('Y-m-d-His').'_query-export.csv';
        $path .= '/'.$file;

        $fp = fopen($path, 'w');
        foreach ($csv_data as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        echo '/downloads/'.$file;
    }

    public function getListUpload(){
        $csv_header = false;
        $csv_data = array();
        $fields = array();

        return View::make('report/listupload')
            ->with('csv_header',$csv_header)
            ->with('csv_data',$csv_data)
            ->with('fields',$fields)
            ->with('active','listupload');
    }

    public function postListUpload(){
        $File = Input::file('file');
        $header = Input::get('header');
        $csv_data = array();
        $csv_header = false;
        $fields = Report::getListFields();

        $filepath = $File->getRealPath();

        if (($handle = fopen($filepath, "r")) !== false) {
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                if($header && $csv_header == false){
                   $csv_header = $row;
                }else{
                   $csv_data[] = $row;
                }
            }
            fclose($handle);
        }

        $destinationPath = storage_path().'/uploads';
        $filename = 'FieldMap_'.date('m-d-y_his').'.csv';
        $File->move($destinationPath, $filename);

        $_SESSION['file'] = $filename;
        $_SESSION['header'] = $header;
        Session::put('file', $filename);

        return View::make('report/listupload')
            ->with('csv_header',$csv_header)
            ->with('csv_data',$csv_data)
            ->with('fields',$fields)
            ->with('active','listupload');
    }

    public function postMapCsv(){
        $filepath = storage_path().'/uploads';
        $file = $filepath.'/'.Session::get('file');;
        $fields = Report::getListFields();
        $map = Input::get('field');
        $excluded_columns = array();
        $mapping = array();
        foreach($map as $column => $data){
            $mapped = $data[0];
            if($mapped == 'none'){
                $excluded_columns[] = $column;
            }else{
                $mapping[$column] = $mapped;
            }
        }

        $parsed = Report::mapCsv($file, Session::get('header'), $mapping, $excluded_columns);

        $out_csv = str_replace('.csv', '_mapped.csv', $file);
        Session::put('mapped_file', $out_csv);

        $handle = fopen($out_csv, 'w');
        foreach ($parsed as $fields) {
            fputcsv($handle, $fields);
        }
        fclose($handle);

        $job_id = Job::getNextID();
        Session::put('job_id', $job_id);

        return View::make('report/listpreview')
            ->with('excluded_columns',$excluded_columns)
            ->with('parsed',$parsed)
            ->with('job_id',$job_id)
            ->with('fields',$fields)
            ->with('active','listupload');
    }

    public function getDownloadCsv(){
        if($file = Session::get('mapped_file')){
            $job_id = Session::get('job_id');
            return Response::download($file, "$job_id.csv");
        }else{
            Redirect::to('reports/list-preview');
        }
    }

    public function getDownloadMfb(){
        if($job_id = Session::get('job_id')){
            $filepath = storage_path().'/configs/mailjob.mjb';
            $template = file_get_contents($filepath);
            $new_config = str_replace('{job_id}', $job_id, $template);
            file_put_contents(storage_path().'/job_files/'.$job_id.'.mjb', $new_config);
            return Response::download(storage_path().'/job_files/'.$job_id.'.mjb');
        }else{
            Redirect::to('reports/list-preview');
        }
    }
}