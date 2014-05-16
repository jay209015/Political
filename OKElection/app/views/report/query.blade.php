@extends('master')

@section('header')
    <h1>Query Voter Information</h1>
@stop

@section('content')
<?php
$count = (isset($voters))? $voters->count(): 0;
?>

<div class="row">
    <div class="col-md-6">
        <div class="well">
            <form action="" method="POST" class="form" role="form">
                <div class="form-group">
                    <label  for="county_code">County Code</label>
                    <input type="text" id="county_code" name="county_code" size="2" placeholder="17" value="<?=$form['county_code']?>"/>
                </div>
                <div class="form-group">
                    <label  for="election_dates">Dates (comma separated)</label>
                    <input type="text" name="election_dates" id="election_dates" placeholder="<?=date('Ymd')?>" value="<?=$form['election_dates']?>"/>
                </div>
                <div class="form-group">
                    <label  for="election_dates">Political Affiliation</label>
                    <select name="affiliation" id="affiliation">
                        <?php foreach($form['affiliation']['options'] as $key => $value): ?>
                        <option value="<?=$key?>" <?=(($key == $form['affiliation']['selected'])? 'SELECTED': '')?>><?=$value?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label  for="county_code">Appears in (n) of Dates</label>
                    <input type="text" name="appears" placeholder="3" value="<?=$form['appears']?>"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Search" class="btn btn-success"/>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <tr>
                <td>Total Voters</td>
                <td><?=$count?></td>
            </tr>
        </table>
    </div>
</div>
@stop