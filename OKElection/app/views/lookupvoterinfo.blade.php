@extends('master')

@section('header')
<h1>Voter Information</h1>
@stop

@section('content')
<ul>
    <li>Total Number of Voters: {{$total}}</li>
    <li>First Name: {{$voter->getFirstName()}}</li>
    <li>Last Name: {{$voter->getLastName()}}</li>
    <li>Number of times voted: </li>
</ul>
@stop