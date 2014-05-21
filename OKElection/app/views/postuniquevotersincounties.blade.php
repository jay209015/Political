@extends('master')

@section('header')
<h1>Listing information for {{$county_name}} County</h1>
@stop

@section('content')
<!--<ul>
    @foreach ($uniqueVoters as $uniqueVoter)
        <li>Precinct Number: {{$uniqueVoter->precinct_number}}</li>
        <ul>
            <li>Count: {{$uniqueVoter->count}}</li>
        </ul>
    @endforeach
    {{$uniqueVoters->appends(Input::only('county_code'))->links()}}
</ul>-->
<div class="row">
    <div class="col-md-2">
        Precinct Number
        <br />
        @foreach ($uniqueVoters as $uniqueVoter)
            {{$uniqueVoter->precinct_number}} <br />
        @endforeach
    </div>
    <div class="col-md-2">
        Count
        <br />
        @foreach ($uniqueVoters as $uniqueVoter)
        {{$uniqueVoter->count}} <br />
        @endforeach
    </div>
</div>
{{$uniqueVoters->appends(Input::only('county_code'))->links()}}
@stop