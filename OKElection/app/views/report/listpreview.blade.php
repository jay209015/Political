@extends('master')

@section('header')
@stop

@section('content')

<?php
    $header = array_shift($parsed);
?>

<div class="row col-md-12">
    <div class="col-md-12">
        <h2>List Preview (Job ID: <?=$job_id?>)
            <a class="btn btn-info" href="/reports/download-csv">Download CSV</a>
            <a class="btn btn-info" href="/reports/download-mfb">Download MJB</a>
        </h2>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                <?php foreach($header as $column_number => $column): ?>
                    <?php if(true || !in_array($column_number, $excluded_columns)): ?>
                    <th><?=$column?></th>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($parsed as $index => $row): ?>
                <tr>
                    <?php foreach($row as $column_number => $column): ?>
                    <?php if(true || !in_array($column_number, $excluded_columns)): ?>
                    <td><?=$column?></td>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
                <?php if($index > 50){ break; } ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
@stop