@extends('master')

@section('header')
<h1>Voter Information</h1>
@stop

@section('content')
<ul>
    <li>First Name: {{$voter->getFirstName()}}</li>
    <li>Middle Name: {{$voter->getMiddleName()}}</li>
    <li>Last Name: {{$voter->getLastName()}}</li>
    <li>Suffix: {{$voter->getSuffix()}}</li>
    <li>Political Affiliation: {{$voter->getPoliticalAffiliation()}}</li>
    <li>Status: {{$voter->getStatus()}}</li>
    <li>Street House Number: {{$voter->getStreetHouseNum()}}</li>
    <li>Street Direction: {{$voter->getStreetDirection()}}</li>
    <li>Street Name: {{$voter->getStreetName()}}</li>
    <li>Street Type: {{$voter->getStreetType()}}</li>
    <li>Building Number: {{$voter->getBuildingNumber()}}</li>
    <li>City: {{$voter->getCity()}}</li>
    <li>Zip Code: {{$voter->getZipCode()}}</li>
    <li>Street Direction: {{$voter->getLastName()}}</li>
    <li>Number of times voted: </li>
</ul>
@stop