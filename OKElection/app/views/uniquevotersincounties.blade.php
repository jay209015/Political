@extends('master')

@section('header')
<h1>Number of Unique Voters per County</h1>
@stop

@section('content')
<ul>
    @foreach ($uniqueVoters as $uniqueVoter)
        <li>County Name: {{$uniqueVoter->county_name}}</li>
        <ul>
            <li>Precinct Number: {{$uniqueVoter->precinct_number}}</li>
            <ul>
                <li>Count: {{$uniqueVoter->count}}</li>
            </ul>
        </ul>
    @endforeach
</ul>
@stop