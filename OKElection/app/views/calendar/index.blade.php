@extends('master')

@section('assets')
<link rel='stylesheet' type='text/css' href="{{asset('css/fullcalendar.css')}}" />
<script type='text/javascript' src="{{asset('js/jquery.livequery.js')}}"></script>
<script type='text/javascript' src="{{asset('js/moment.min.js')}}"></script>
<script type='text/javascript' src="{{asset('js/fullcalendar.js')}}"></script>
<!--Include Avgrund modal https://github.com/voronianski/jquery.avgrund.js-->
<link rel='stylesheet' type='text/css' href="{{asset('css/avgrund.css')}}" />
<script type='text/javascript' src="{{asset('js/jquery.avgrund.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#calendar').fullCalendar({
            events: '/calendar/feed',
            eventClick: function(calEvent, jsEvent, view) {
                $('.fc-event-container').avgrund({
                    width: 640,
                    height: 350,
                    holderClass: 'custom',
                    showClose: true,
                    showCloseText: 'close',
                    onBlurContainer: '.container',
                    template: '<div id="template"></div>'

                });
                //wait for dynamically created element to be added to DOM
                $("#template").livequery(function(){
                    $("#template").load( "/calendar/event-feed?start=" + moment(calEvent.start).unix());
                });
            }
        })

    });
</script>
@stop

@section('header')
<h1>Candidate Events Calendar</h1>
@stop

@section('content')
<div id="calendar" ></div>

@stop