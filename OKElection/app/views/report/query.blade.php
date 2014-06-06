@extends('master')

@section('assets')
<script src="{{asset('js/RedQueryBuilder/RedQueryBuilder.nocache.js')}}" type="text/javascript">//</script>
<link rel="stylesheet" href="{{asset('js/RedQueryBuilder/gwt/dark/dark.css')}}" type="text/css" />
<script src="{{asset('js/RedQueryBuilder/RedQueryBuilderFactory.nocache.js')}}" type="text/javascript">//</script>
<script src="{{asset('js/simple.js')}}" type="text/javascript">//</script>
@stop

@section('header')
    <h1>Query Voter Information</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="well">
            <form action="" method="POST" class="form" role="form">
                <div class="form-group">
                    <label  for="county_code">County</label>
                    <select name="county_code" id="county_code">
                        @foreach ($form['counties']['options'] as $option):
                            <option value="{{{$option['id']}}}" <?=(($option['id'] == $form['counties']['selected'])? 'SELECTED': '')?>>{{{$option['name']}}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label  for="election_dates">Dates (comma separated)</label>
                    <input type="text" name="election_dates" id="election_dates" placeholder="{{{$placeholder_date or ''}}}" value="{{{$form['election_dates']}}}"/>
                </div>
                <div class="form-group">
                    <label  for="election_dates">Political Affiliation</label>
                    <select name="affiliation" id="affiliation">
                        @foreach ($form['affiliation']['options'] as $key => $value)
                        <option value="{{$key}}" <?=(($key == $form['affiliation']['selected'])? 'SELECTED': '')?>>{{{$value}}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label  for="county_code">Appears in (n) of Dates</label>
                    <input type="text" name="appears" placeholder="3" value="{{{$form['appears']}}}"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Search" class="btn btn-success"/>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <tr>
                <td>Total Voters</td>
                <td>{{{$count or ''}}}</td>
            </tr>
        </table>
    </div>
</div>


<h1>Custom Query Builder</h1>


<noscript>
    <div style="width: 22em; position: absolute; left: 50%; margin-left: -11em; color: red; background-color:white; border: 1px solid red; padding: 4px; font-family: sans-serif">
        Your web browser must have JavaScript enabled
        in order for this application to display correctly.
    </div>
</noscript>

<div id="rqb">&nbsp;</div>

<div><textarea id="debug" cols="80" rows="10">debug output</textarea></div>
@stop

@section('assets_footer')

@stop