var QueryBuilder = angular.module('QueryBuilder', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

QueryBuilder.controller('QueryFields', function ($scope, $filter) {

    $scope.queryString = '';

    $scope.comparisons = ['=', '!=', '>', '>=', '<', '<='];

    $scope.operators = ['AND','OR'];

    $scope.columns = queryFields;


    $scope.defaultField = angular.copy($scope.columns[0]);

    $scope.defaultGroup = {
        rows: [
            {
                field: angular.copy($scope.defaultField)
            }
        ],
        'operator': $scope.operators[0]
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

    $scope.changeColumn = function(group_id, row_id, column){
        $scope.groups[group_id].rows[row_id].field = angular.copy(column)
    }

    $scope.postQuery = function(){
        $scope.queryString = '';

        angular.forEach($scope.groups, function(group, group_id) {

            if(typeof group.operator != 'undefined' && $scope.operators.indexOf(group.operator) != -1 ){
                $scope.queryString += ' ' +group.operator+ ' ';
            }
            $scope.queryString += '(';

            row_index = 0;
            angular.forEach(group.rows, function(row, row_id) {
                if(row_index != 0){
                    $scope.queryString += ' ' +row.field.operator+ ' ';
                }

                $scope.queryString += row.field.name +
                    ' ' +
                    row.field.comparison + ' ';

                if(typeof row.field.value == 'object'){
                    $scope.queryString += row.field.value.value;
                }else{
                    $scope.queryString += row.field.value;
                }

                row_index++;
            });

            $scope.queryString += ')';
        });

        console.log($scope.queryString);
    }
});