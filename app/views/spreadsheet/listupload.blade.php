@extends('master')

@section('assets')
<link href="/assets/global/plugins/dropzone/css/dropzone.css" rel="stylesheet"/>
@stop

@section('title')
    File Upload
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
    <div class="col-md-12">
        <p>
                    <span class="label label-danger">
                    NOTE: </span>
            &nbsp; This plugins works only on Latest Chrome, Firefox, Safari, Opera & Internet Explorer 10.
        </p>
        <form action="/spreadsheet/upload" class="dropzone" id="mydropzone" enctype="multipart/form-data">
        </form>
    </div>

</div>
@section('scripts')
<script src="/assets/global/plugins/dropzone/dropzone.js"></script>
<script src="/assets/admin/pages/scripts/form-dropzone.js"></script>
<script>
    jQuery(document).ready(function() {

        Dropzone.options.mydropzone = {
            init: function(){
               this.on('complete', function(){
                    location.href = 'edit-csv';
                })
            },
            accept: function(file, done) {
                done();
            }
        }
        FormDropzone.init();

    });
</script>
@stop

@stop