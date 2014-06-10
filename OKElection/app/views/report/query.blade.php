@extends('master')

@section('assets')
@stop

@section('header')
    <h1>Query Voter Information</h1>
@stop

@section('content')

<div ng-app="QueryBuilder">
    <script type="text/ng-template"  id="group_template.html">
        <div class="operator" ng-if="!$first" style="margin-top:-20px; margin-left: -20px; margin-bottom: 10px">
            <select ng-model="group.operator" ng-options="operator for operator in operators"></select>
        </div>

        <button class="btn btn-sm btn-success" ng-click="addRow(group)">Add Condition</button>
        <button class="btn btn-sm btn-danger" ng-click="removeGroup(group_id)">Remove Group</button>
        <div class="row" ng-repeat="(row_id, row) in group.rows">
            <div class="operator" ng-if="!$first">
                <select ng-model="row.field.operator" ng-options="operator for operator in operators"></select>
            </div>
            <table ng-if="row.type == 'field'">
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
            <div class="group well" ng-if="row.type == 'group'" ng-include="'group_template.html'"></div>
        </div>
    </script>
    <div ng-controller="QueryFields">
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-sm btn-success" ng-click="addGroup()">Add Group</button>
                <div class="group well" ng-repeat="(group_id, group) in groups" ng-include="'group_template.html'">

                </div>
                <button class="btn btn-success" ng-click="postQuery()">Search</button>
            </div>
            <div class="col-md-6">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Total Voters</td>
                        <td><pre><%queryResults%></pre></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var queryFields = <?=json_encode($fields);?>;
</script>
<script src="{{asset('js/encoding.js')}}"></script>
<script src="{{asset('js/QueryBuilderController.js')}}"></script>


@stop

@section('assets_footer')

@stop