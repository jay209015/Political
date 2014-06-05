@extends('master')

@section('assets')
@stop

@section('header')
<h1>List Information by County Name</h1>
@stop

@section('content')
<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <form role="form" method="get" action="unique-voters-per-county-info">
            <fieldset>
                <h2>Select a County</h2>
                <hr>
                <div class="form-group">
                    <label  for="county_code">County</label>
                    <select name="county_code" id="county_code">
                        @foreach ($form['counties']['options'] as $option):
                        <option value="{{{$option['id']}}}" <?=(($option['id'] == $form['counties']['selected'])? 'SELECTED': '')?>>{{{$option['name']}}}</option>
                        @endforeach
                    </select>
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