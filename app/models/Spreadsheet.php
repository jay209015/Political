<?php

/**
 * Stores all query logic to the database for reports.
 *
 * @author   Jay Rivers <jayrivers@printplace.com>
 */
class Spreadsheet {

    public function __construct()
    {
        //Todo
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

    public static function CSV2Array($file){
        $data = array();
        $index = 0;
        if (($handle = fopen($file, 'r')) !== false){
            while (($row = fgetcsv($handle, 1000, ',')) !== false){
                $data[$index] = $row;
                $index++;
            }
            fclose($handle);
        }
        return $data;
    }

    public static function mapCsv($file, $has_header, $mapping, $exclusions = array()){
        $fields = Spreadsheet::getListFields();
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