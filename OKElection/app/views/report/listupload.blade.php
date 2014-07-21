@extends('master')

@section('header')
@stop

@section('content')
<?php
$field_select = '<select name="field[{column}][]">';
$field_select .= '<option value="none">none</option>';
foreach($fields as $key => $field){
    $field_select .= '<option value="'.$key.'">'.$field['display'].'</option>';
}
$field_select .= '</select>';
?>
<div class="row col-md-12">
    <div class="col-md-4">
        <h2>List Upload</h2>
        <form action="" method="post"enctype="multipart/form-data" role="form" class="form-horizontal">
            <div class="form-group">
                <input class="form-control" type="file" name="file" id="file">
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="header" id="header"> Header Present?
                    </label>
                </div>
            </div>
            <div class="form-group">
                <input class="form-control btn btn-success" type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>

    <div class="col-md-8">
        <h2>Field Mapping</h2>
        <?php if($csv_data){ ?>
        <form action="/reports/map-csv" method="POST">
            <table class="table table-bordered">
                <tr>
                    <?php if($csv_header){ ?>
                    <th>Header</th>
                    <?php } ?>
                    <th>Data</th>
                    <th>Field</th>
                </tr>
                <?php if($csv_header) { ?>
                <?php foreach($csv_header as $column => $value) { ?>
                <tr>
                    <td><?=(trim($value))? $value: '{Blank}'?></td>
                    <td><?=(trim($csv_data[0][$column]))? $csv_data[0][$column]: '{Blank}'?></td>
                    <td><?=str_replace('{column}', $column, $field_select)?></td>
                </tr>

                <?php } ?>
                <?php }else{ ?>
                <?php foreach($csv_data[0] as $column => $value) { ?>
                    <tr>
                        <td><?=(trim($value))? $value: '{Blank}'?></td>
                        <td><?=str_replace('{column}', $column, $field_select)?></td>
                    </tr>
                <?php } ?>
                <?php } ?>
                <tr>
                    <td colspan="<?php echo ($csv_header)? '3': '2';?>">
                        <input type="submit" class="btn btn-success" name="Map" value="Update"/>
                    </td>
                </tr>
            </table>
        </form>
        <?php } ?>
    </div>
</div>
@stop