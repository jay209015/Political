var QueryBuilder = angular.module('QueryBuilder', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

QueryBuilder.controller('QueryFields', function ($scope, $filter) {

    $scope.comparisons = ['=', '!=', '>', '>=', '<', '<='];

    $scope.operators = ['AND','OR'];

    $scope.columns = [
        {
            'name':'county',
            'title':'County',
            'value': false,
            'options': [
                {
                    'id': 1,
                    'name':'Adair'
                }
            ],
            'type': 'select',
            'comparison': angular.copy($scope.comparisons[0]),
            'operator': angular.copy($scope.operators[0])
        },
        {
            'name':'election_date',
            'title':'Election Date',
            'value': '',
            'type': 'text',
            'options': false,
            'comparison': angular.copy($scope.comparisons[0]),
            'operator': angular.copy($scope.operators[0])
        }
    ];


    $scope.defaultField = angular.copy($scope.columns[0]);

    $scope.defaultGroup = {
        rows: [
            {
                field: angular.copy($scope.defaultField)
            }
        ]
    };

    $scope.groups = [];

    $scope.addRow = function(group){
        group.rows.push({field: angular.copy($scope.defaultField)});
    };

    $scope.removeRow = function(group_id, row_id){
        $scope.groups[group_id].rows.splice(row_id,1);

    };

    $scope.addGroup = function(){
        $scope.groups.push({
            rows: [
                {
                    field: angular.copy($scope.defaultField)
                }
            ]
        });
    };

    $scope.removeGroup = function(group_id){
        $scope.groups.splice(group_id,1);
    };

    $scope.$watchCollection('groups', function() {
    });

    $scope.changeColumn = function(group_id, row_id, column){
        $scope.groups[group_id].rows[row_id].field = angular.copy(column)
    }
});