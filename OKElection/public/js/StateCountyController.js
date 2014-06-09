var StateCounty = angular.module('StateCounty', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

StateCounty.controller('StateCountyOptions', function ($scope, $filter) {
    $scope.counties = [
        {
            'name': 'Smith',
            'id': '1',
            'state': 'Texas'
        },
        {
            'name': 'Adair',
            'id': '1',
            'state': 'Oklahoma'
        },
        {
            'name': 'Alfalfa',
            'id': '2',
            'state': 'Oklahoma'
        },
        {
            'name': 'Atoka',
            'id': '3',
            'state': 'Oklahoma'
        }
    ];
    $scope.states = [
        {
            'name': 'Texas'
        },
        {
            'name': 'Oklahoma'
        }
    ]
    $scope.stateList = $scope.states[1];
});
