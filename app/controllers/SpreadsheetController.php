<?php

/**
 * Logic handling report
 */
class SpreadsheetController extends BaseController {

    public function getUpload(){
        $csv_header = false;
        $csv_data = array();
        $fields = array();

        return View::make('spreadsheet/listupload')
            ->with('csv_header',$csv_header)
            ->with('csv_data',$csv_data)
            ->with('fields',$fields)
            ->with('active','listupload');
    }

    public function postUpload(){
        $File = Input::file('file');
        $header = Input::get('header');
        $csv_data = array();
        $csv_header = false;
        $fields = Spreadsheet::getListFields();
        $orig_name = $File->getClientOriginalName();

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

        Session::put('file', $filename);
        Session::put('file_name', $orig_name);

        return View::make('spreadsheet/listupload')
            ->with('csv_header',$csv_header)
            ->with('csv_data',$csv_data)
            ->with('fields',$fields)
            ->with('active','listupload');
    }

    public function getEditCsv(){
        if(Session::get('file')){
            $filepath = storage_path().'/uploads';
            $file = $filepath.'/'.Session::get('file');

            $csv_header = false;
            if($csv_data = Spreadsheet::CSV2Array($file)){
                $orig_name = Session::get('file_name');

                return View::make('spreadsheet/listcsv')
                    ->with('csv_header',$csv_header)
                    ->with('filename',$orig_name)
                    ->with('csv_data',$csv_data);
            }else{
               return Redirect::to('spreadsheet/upload');
            }
        }else{
            return Redirect::to('spreadsheet/upload');
        }
    }

    public function postMapCsv(){
        $filepath = storage_path().'/uploads';
        $file = $filepath.'/'.Session::get('file');
        $fields = Spreadsheet::getListFields();
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

        $parsed = Spreadsheet::mapCsv($file, Session::get('header'), $mapping, $excluded_columns);

        $out_csv = str_replace('.csv', '_mapped.csv', $file);
        Session::put('mapped_file', $out_csv);

        $handle = fopen($out_csv, 'w');
        foreach ($parsed as $fields) {
            fputcsv($handle, $fields);
        }
        fclose($handle);

        $job_id = Job::getNextID();
        Session::put('job_id', $job_id);

        return View::make('spreadsheet/listpreview')
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

    public function postUpdateOptions(){
        $options = Input::get('options');
        Session::put('mail_options', $options);
    }

    public function getDownloadMfb(){
        if($job_id = Session::get('job_id')){
            $filepath = storage_path().'/configs/mailjob.mjb';
            $template = file_get_contents($filepath);
            $options = Session::get('mail_options');
            $snippets = array();

            $duplicate_removals = $options['duplicate_removals'];
            $mail_class = $options['mail_class'];
            $data_services = $options['data_services'];
            $data_quality = $options['data_quality'];


            if($data_services != 'none'){
                $snippets[] = file_get_contents(storage_path().'/configs/'.'data-service-'.$data_services);
            }

            if($duplicate_removals != 'none'){
                $snippets[] = file_get_contents(storage_path().'/configs/'.'dedupe-'.$duplicate_removals);
            }

            /*
            if($data_quality != 'none'){
                $snippets[] = 'data-quality-'.$data_quality;
            }
            */

            /*
            if($mail_class != 'none'){
                $snippets[] = 'mail-class-'.$mail_class;
            }
            */

            foreach($snippets as $snippet){
                $template .= "\n".$snippet."\n";
            }

            $new_config = str_replace('{job_id}', $job_id, $template);
            file_put_contents(storage_path().'/job_files/'.$job_id.'.mjb', $new_config);
            return Response::download(storage_path().'/job_files/'.$job_id.'.mjb');
        }else{
            Redirect::to('reports/list-preview');
        }
    }
}