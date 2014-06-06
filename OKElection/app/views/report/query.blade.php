@extends('master')

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

<div class="container">
    <h1>Custom Query Builder</h1>
    <div class="alert alert-info">
        <strong>Example Output</strong><br/>
        <span data-bind="text: text"></span>
    </div>
    <div data-bind="with: group">
        <div data-bind="template: templateName"></div>
    </div>
</div>

<!-- HTML Template For Conditions -->
<script id="condition-template" type="text/html">
    <div class="condition">
        <select data-bind="options: fields, value: selectedField"></select>
        <select data-bind="options: comparisons, value: selectedComparison"></select>
        <input type="text" data-bind="value: value"></input>
        <button class="btn btn-danger btn-xs" data-bind="click: $parent.removeChild"><span class="glyphicon glyphicon-minus-sign"></span></button>
    </div>
</script>

<!-- HTML Template For Groups -->
<script id="group-template" type="text/html">
    <div class="alert alert-warning alert-group">
        <select data-bind="options: logicalOperators, value: selectedLogicalOperator"></select>
        <button class="btn btn-xs btn-success" data-bind="click: addCondition"><span class="glyphicon glyphicon-plus-sign"></span> Add Condition</button>
        <button class="btn btn-xs btn-success" data-bind="click: addGroup"><span class="glyphicon glyphicon-plus-sign"></span> Add Group</button>
        <button class="btn btn-xs btn-danger" data-bind="click: $parent.removeChild"><span class="glyphicon glyphicon-minus-sign"></span> Remove Group</button>
        <div class="group-conditions">
            <div data-bind="foreach: children">
                <div data-bind="template: templateName"></div>
            </div>
        </div>
    </div>
</script>
@stop

@section('assets_footer')
<!-- js -->
<script src="{{asset('js/knockout-2.2.1.js')}}"></script>
<script src="{{asset('js/condition.js')}}"></script>
<script src="{{asset('js/group.js')}}"></script>
<script src="{{asset('js/viewModel.js')}}"></script>
<script>
    window.addEventListener('load', function(){
        ko.applyBindings(new QueryBuilder.ViewModel());
    }, true);
</script>
@stop