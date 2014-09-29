@extends('master')

@section('assets')
<link href="{{asset('css/multiselect.css')}}" rel="stylesheet" />
<link href="{{asset('css/queryBuilder.css')}}" rel="stylesheet" />
@stop

@section('header')
    <h1>Query Voter Information</h1>
@stop

@section('content')

<div ng-app="QueryBuilder">
    <script type="text/ng-template"  id="group_template.html">

        <div class="operator group-operator" ng-if="!$first" style="">
            <select ng-model="group.operator" ng-options="operator for operator in operators"></select>
        </div>

        <button class="group-remove" ng-click="removeGroup(group_id)"><span class="glyphicon glyphicon-remove"></span></button>

        <div class="" ng-if="!$first" style="height: 5px;">

        </div>
        <div class="group-row" ng-repeat="(row_id, row) in group.rows">
            <div class="operator" ng-if="!$first">
                <select ng-model="row.field.operator" ng-options="operator for operator in operators"></select>
            </div>
            <table ng-if="row.type == 'field'" class="table table-bordered table-condensed condition-table">
                <tr>
                    <td>
                        <select ng-model="updatedColumn" ng-change="changeColumn(group_id, row_id, updatedColumn)" ng-options="column.title for column in columns"></select>
                    </td>
                    <td>
                        <select ng-model="row.field.comparison" ng-change="changeComparison(group_id, row_id, row.field.comparison)" ng-options="comparison.display for comparison in comparisons"></select>
                    </td>
                    <td>
                        <select ng-model="row.field.value" ng-class="row.field.class" ng-if="row.field.type == 'select'" ng-options="option.name for option in row.field.options"></select>
                        <select ng-model="row.field.value" class="multiselect-<%group_id%>-<%row_id%>" ng-if="row.field.type == 'multiselect'" multiple="multiple" ng-options="option.name for option in row.field.options"></select>
                        <input ng-model="row.field.value" ng-class="row.field.class" ng-if="row.field.type == 'text'" type="text" />
                    </td>
                    <td>
                        <button class="btn btn-xs group-btn" ng-click="removeRow(group_id, row_id)"><span class="glyphicon glyphicon-minus"></span></button>
                    </td>
                </tr>
            </table>
            <div class="group well" ng-if="row.type == 'group'" ng-include="'group_template.html'"></div>
        </div>

        <button class="group-btn group-add-condition" ng-click="addRow(group_id)"><span class="glyphicon glyphicon-plus"></span> Add Condition</button>
        <div style="clear:both"></div>
    </script>

    <div ng-controller="QueryFields">
        <div class="row">
            <div class="col-md-8">
                <div class="group" ng-repeat="(group_id, group) in groups" ng-include="'group_template.html'"></div>
                <div>
                    <button class="group-btn group-add" ng-click="addGroup()"><span class="glyphicon glyphicon-plus"></span> Add Group</button>
                    <div style="clear:both"></div>
                </div>
                 <button class="group-btn" ng-click="postQuery()">Search</button>
                 <button class="group-btn" ng-click="exportQuery()">Export</button>
            </div>
            <div class="col-md-4 group">
                Total Voters: <pre><%queryResults%></pre>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var queryFields = <?=json_encode($fields);?>;
    var queryComparisons = <?=json_encode($comparisons);?>
</script>
<script src="{{asset('js/encoding.js')}}"></script>
<script src="{{asset('js/multiselect.js')}}"></script>
<script src="{{asset('js/QueryBuilderController.js')}}"></script>
<script src="{{asset('js/QueryGroupModel.js')}}"></script>
<script src="{{asset('js/QueryRowModel.js')}}"></script>


@stop

@section('assets_footer')

@stop