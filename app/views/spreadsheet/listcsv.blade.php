@extends('master')

@section('assets')
@stop

@section('title')
Edit Spreadsheet
@stop

@section('content')
<?php if($csv_data){ ?>
    <div class="col-md-12">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i><?php echo $filename; ?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse">
            </a>
            <a href="#portlet-config" data-toggle="modal" class="config">
            </a>
        </div>
    </div>
    <div class="portlet-body">
    <table class="table table-bordered table-striped table-condensed">
    <tbody>
    <?php foreach($csv_data as $row => $columns){ ?>
    <tr>
        <?php foreach($columns as $column){ ?>
        <td><?php echo $column ?></td>
        <?php } ?>
    </tr>
    <?php } ?>

    </tbody>
    </table>
    </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->


    </div>
<?php } ?>
@stop

@section('scripts')
@stop