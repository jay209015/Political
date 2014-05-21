@extends('master')

@section('header')
<h1>Number of Unique Voters per County</h1>
@stop

@section('content')
<ul>
    @foreach ($uniqueVoters as $uniqueVoter)
        <li>{{$uniqueVoter->county_name}}</li>
        <ul>
            <li>{{$uniqueVoter->count}}</li>
        </ul>
    @endforeach
</ul>
@stop