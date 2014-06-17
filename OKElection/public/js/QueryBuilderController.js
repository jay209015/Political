var QueryBuilder = angular.module('QueryBuilder', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

QueryBuilder.controller('QueryFields', function ($scope, $filter, $http) {

    $scope.queryString = '';

    $scope.comparisons = queryComparisons;

    $scope.operators = ['AND','OR'];

    $scope.columns = queryFields;
    $scope.updatedColumn = $scope.columns[0].title;

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
            $scope.addRow(($scope.groups.length - 1));
        }
    };

    $scope.addRow = function(group_id){
        console.log($scope.defaultField);
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

    $scope.changeComparison = function(group_id, row_id, comparison){
        console.log($scope.groups[group_id].rows[row_id]);
        if(comparison.value == 'IN'){
            // Enable multiselect
            $scope.groups[group_id].rows[row_id].field.type = 'multiselect';
            $scope.$apply();
            $(".multiselect-"+group_id+"-"+row_id).multiselect();
        }else{
           // Disable multiselect
            $scope.groups[group_id].rows[row_id].class = "";
            if($scope.groups[group_id].rows[row_id].field.type == 'multiselect'){
                $scope.groups[group_id].rows[row_id].field.type = 'select';
            }
        }
    }

    $scope.addGroup();

    $scope.postQuery = function(){
        $scope.queryString = '';
        var selected;
        var value;
        var total_selected;

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
                    row.field.comparison.value + ' ';

                if(typeof row.field.value == 'object'){
                    if(row.field.type == 'multiselect'){
                        selected = jQuery('.multiselect-'+group_id+'-'+row_id+' option:selected');
                        total_selected = selected.length;
                        $scope.queryString += '[';
                        angular.forEach(selected, function(option, option_index){
                            value = jQuery(option).val();
                            $scope.queryString += ""+row.field.options[value].value+"";
                            if(option_index < total_selected - 1){
                                $scope.queryString += ",";
                            }
                        });
                        $scope.queryString += ']';
                        console.log(selected);
                    }else{
                        $scope.queryString += row.field.value.value;
                    }
                }else{
                    $scope.queryString += row.field.value;
                }

                row_index++;
            });

            $scope.queryString += ')';
        });

        console.log($scope.queryString);

        $http.post('/reports/query', {q:Base64.encode($scope.queryString)}).success(function(data){
           $scope.queryResults = data;
        })
    }
});