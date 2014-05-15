@extends('master')

@section('header')
    <h1>Query Voter Information</h1>
@stop

@section('content')
<?php if(isset($voters) && $count = $voters->count()): ?>
<table class="table table-striped table-bordered">
    <tr>
        <td>Total Voters</td>
        <td><?=$count?></td>
    </tr>
</table>
<?php endif; ?>

<form action="" method="POST" class="form-inline" role="form">
    <div class="form-group">
        <label  for="county_code">County Code</label>
        <input type="text" class="form-control" id="county_code" name="county_code" size="2" placeholder="17" value="<?=$form['county_code']?>"/>
    </div>
    <div class="form-group">
        <label  for="election_dates">Dates</label>
        <input type="text" name="election_dates" id="election_dates" placeholder="<?=date('Ymd')?>" value="<?=$form['election_dates']?>"/>
    </div>
    <div class="form-group">
        <label  for="county_code">Appears in (n) of Dates (not yet functioning)</label>
        <input type="text" name="appears" placeholder="3" value="<?=$form['appears']?>"/>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Search" class="btn btn-success"/>
    </div>
</form>
@stop