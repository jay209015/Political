QueryBuilder.service('QueryGroup', function($http, $scope) {


    // instantiate our initial object
    this.QueryGroup = function() {
        this.rows = [];
        this.operator = $scope.operators[0];
    };

    this.addRow = function(){
        console.log('here');
        console.log(angular.copy($scope.defaultField));
        this.rows.push(new QueryRowModel('field', angular.copy($scope.defaultField)));
    }

    this.removeRow = function(row_id){
        this.rows.splice(row_id,1);
    }

});