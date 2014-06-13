var QueryBuilder = angular.module('QueryBuilder', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

QueryBuilder.controller('QueryFields', function ($scope, $filter, $http) {

    $scope.queryString = '';

    $scope.comparisons = ['=', '!=', '>', '>=', '<', '<='];

    $scope.operators = ['AND','OR'];

    $scope.columns = queryFields;

    $scope.queryResults = "Please run a query";


    $scope.defaultField = angular.copy($scope.columns[0]);

    $scope.defaultGroup = {
        rows: [],
        operator: $scope.operators[0]
    };

    $scope.groups = [];

    $scope.addGroup = function(group_id){
        if(typeof group_id != 'undefined'){
            $scope.groups[group_id].rows.push(angular.copy($scope.defaultGroup));
            var last_row_index = $scope.groups[group_id].rows.length - 1;
            $scope.groups[group_id].rows[last_row_index].type = 'group';
        }else{
            $scope.groups.push(angular.copy($scope.defaultGroup));
        }
    };

    $scope.addRow = function(group_id){
        $scope.groups[group_id].rows.push({
            field:angular.copy($scope.defaultField),
            type: 'field'
        });
    }

    $scope.removeRow = function(group_id, row_id){
        $scope.groups[group_id].rows.splice(row_id,1);
    }

    $scope.removeGroup = function(group_id){
        $scope.groups.splice(group_id,1);
    };

    $scope.changeColumn = function(group_id, row_id, column){
        $scope.groups[group_id].rows[row_id].field = angular.copy(column)
    }

    $scope.postQuery = function(){
        $scope.queryString = '';

        angular.forEach($scope.groups, function(group, group_id) {

            if($scope.queryString.length > 0){
                if(typeof group.operator != 'undefined' && $scope.operators.indexOf(group.operator) != -1 ){
                    $scope.queryString += ' ' +group.operator+ ' ';
                }
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

        $http.post('/reports/query', {q:Base64.encode($scope.queryString)}).success(function(data){
           $scope.queryResults = data;
        })
    }
});