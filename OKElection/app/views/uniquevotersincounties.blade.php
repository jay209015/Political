@extends('master')

@section('header')
<h1>Number of Unique Voters per County per Precinct (District)</h1>
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
    {{$uniqueVoters->links()}}
</ul>
@stop