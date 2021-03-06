@extends('master')

@section('header')
@stop

@section('content')

<?php
    $header = array_shift($parsed);
?>
<div class="row col-md-12">
    <div class="col-md-12"><h2>Mail Job Settings</h2></div>

    <form role="form">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Services</h3>
                </div>
                <div class="panel-body">
                    <label>
                        <input type="radio" name="data_services" value="ncoa" CHECKED /> NCOA
                    </label><br />
                    <label>
                        <input type="radio" name="data_services" value="current-occupant"/> or Current Occupant
                    </label><br />
                    <label>
                        <input type="radio" name="data_services" value="none"/> None / Ancillary Endorsement
                    </label><br />
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Duplicate Removals</h3>
                </div>
                <div class="panel-body">
                    <label>
                        <input type="radio" name="duplicate_removals" value="none" CHECKED /> Don't Remove Duplicates
                    </label><br />
                    <label>
                        <input type="radio" name="duplicate_removals" value="address-only"/> Address Only
                    </label><br />
                    <label>
                        <input type="radio" name="duplicate_removals" value="address-last"/> Last Name & Address
                    </label><br />
                    <label>
                        <input type="radio" name="duplicate_removals" value="address-full"/> Full Name & Address
                    </label><br />
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Quality</h3>
                </div>
                <div class="panel-body">
                    <label>
                        <input type="radio" name="data_quality" /> Deliver to All Address
                    </label><br />
                    <label>
                        <input type="radio" name="data_quality" CHECKED/> Only USPS Good Addresses
                    </label><br />
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Mail Class</h3>
                </div>
                <div class="panel-body">
                    <label>
                        <input type="radio" name="mail_class" /> First Class <br />
                        <sub>(Usually delivers in 1‐3 days after mail date)<sub>
                    </label><br />
                    <label>
                        <input type="radio" name="mail_class" CHECKED/> Standard Mail <br />
                        <sub>(Usually delivers in 3‐14 days after mail date)</sub>
                    </label><br />
                    <label>
                        <input type="radio" name="mail_class" /> Non Profit <br />
                        <sub>(Usually delivers in 3‐14 days after mail date)</sub>
                    </label><br />
                </div>
            </div>
        </div>

    </form>



</div>

<hr />

<div class="row col-md-12">

    <div class="col-md-12">
        <h2>List Preview (Job ID: <?=$job_id?>)
            <a class="btn btn-info" href="/reports/download-csv">Download CSV</a>
            <a class="btn btn-info" href="javascript:void(0)" onclick="update_options();">Download MJB</a>
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
<script type="text/javascript">
    function update_options(){
        data = {};
        data.options = {};
        data.options.data_quality = $('input[name="data_quality"]:checked').val();
        data.options.mail_class = $('input[name="mail_class"]:checked').val();
        data.options.data_services = $('input[name="data_services"]:checked').val();
        data.options.duplicate_removals = $('input[name="duplicate_removals"]:checked').val();

        jQuery.ajax({
            type: "POST",
            url: '/reports/update-options',
            data: data,
            async: false,
            success: function(){
                location.href = '/reports/download-mfb';
            }
        });
    }
</script>
@stop