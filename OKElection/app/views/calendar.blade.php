@extends('master')

@section('assets')
<link rel='stylesheet' type='text/css' href="{{asset('css/fullcalendar.css')}}" />
<script type='text/javascript' src="{{asset('js/fullcalendar.js')}}"></script>
<!--Include Avgrund modal https://github.com/voronianski/jquery.avgrund.js-->
<link rel='stylesheet' type='text/css' href="{{asset('css/avgrund.css')}}" />
<script type='text/javascript' src="{{asset('js/jquery.avgrund.js')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#calendar').fullCalendar({
            events: '/calendar-feed',
            eventClick: function(calEvent, jsEvent, view) {
                $('#calendar').avgrund({
                    width: 640,
                    height: 350,
                    holderClass: 'custom',
                    showClose: true,
                    showCloseText: 'close',
                    onBlurContainer: '.container',
                    template: 'Candidate information goes here' +
                        '<div>' +
                        'Candidate Line 1' +
                        'Candidate Line 2' +
                        'Candidate Line 3' +
                        '</div>'

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