@extends('master')

@section('header')
<h1>Listing information for {{$county_name}} County</h1>
@stop

@section('content')
<ul>
    @foreach ($uniqueVoters as $uniqueVoter)
        <li>Precinct Number: {{$uniqueVoter->precinct_number}}</li>
        <ul>
            <li>Count: {{$uniqueVoter->count}}</li>
        </ul>
    @endforeach
    {{$uniqueVoters->appends(Input::only('county_code'))->links()}}
</ul>
@stop