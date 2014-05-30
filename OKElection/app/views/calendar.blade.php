@extends('master')

@section('assets')
<link rel='stylesheet' type='text/css' href="{{asset('css/fullcalendar.css')}}" />
<script type='text/javascript' src="{{asset('js/fullcalendar.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {

        // page is now ready, initialize the calendar...

        jQuery('#calendar').fullCalendar({
            events: '/calendar-feed',
            dayClick: function(calEvent, jsEvent, view) {
                window.location = '/calendar-details/' + calEvent.start + '/' + calEvent.end;
            }
        })

    });
</script>
@stop

@section('header')
<h1>Candidate Events Calendar</h1>
@stop

@section('content')
<div id="calendar"></div>
@stop