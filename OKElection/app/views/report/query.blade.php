@extends('master')

@section('assets')
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

<div ng-app="QueryBuilder">
    <div ng-controller="QueryFields">
        <button class="btn btn-sm btn-success" ng-click="addGroup()">Add Group</button>
        <div class="group well" ng-repeat="(group_id, group) in groups">
            <button class="btn btn-sm btn-success" ng-click="addRow(group)">Add Condition</button>
            <button class="btn btn-sm btn-danger" ng-click="removeGroup(group_id)">Remove Group</button>
            <div class="row" ng-repeat="(row_id, row) in group.rows">
                <table>
                    <tr>
                        <td>
                            <select ng-model="updatedColumn" ng-change="changeColumn(group_id, row_id, updatedColumn)" ng-options="column.title for column in columns"></select>
                        </td>
                        <td>
                            <select ng-model="row.field.comparison" ng-options="comparison for comparison in comparisons"></select>
                        </td>
                        <td>
                            <select ng-model="row.field.value" ng-if="row.field.type == 'select'" ng-options="option.name for option in row.field.options"></select>
                            <input ng-model="row.field.value" ng-if="row.field.type == 'text'" type="text" />
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger" ng-click="removeRow(group_id, row_id)">Remove</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/QueryBuilderController.js')}}"></script>

<h1>Custom Query Builder</h1>

@stop

@section('assets_footer')

@stop