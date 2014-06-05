@extends('master')

@section('header')
<h1>Listing information for {{$county_name}} County</h1>
@stop

@section('content')
<div class="row col-md-6">
    <div class="row bg-primary">
        <div class="col-md-4">
            <span>Precinct Number</span>
        </div>
        <div class="col-md-3">
            <span>Number of Votes</span>
        </div>
    </div>
    @foreach ($uniqueVoters as $uniqueVoter)
    <div class="row">
        <div class="col-md-4">
            <span>{{$uniqueVoter->precinct_number}}</span>
        </div>
        <div class="col-md-2">
            <span>{{$uniqueVoter->count}}</span>
        </div>
    </div>
    @endforeach
    {{$uniqueVoters->appends(Input::only('county_code'))->links()}}
</div>
@stop