@extends('master')

@section('assets')
@stop

@section('header')
<h1>Lookup Information by Voter ID</h1>
@stop

@section('content')
<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <form role="form" method="post">
            <fieldset>
                <h2>Enter a Voter ID</h2>
                <hr>
                <div class="form-group">
                    <input type="text" name="voter_id_num" id="voter_id_num" class="form-control input-lg" placeholder="Voter ID Number">
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Generate Report">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@stop