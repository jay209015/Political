var StateCounty = angular.module('StateCounty', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

StateCounty.controller('StateCountyOptions', function ($scope, $filter) {
    $scope.counties = [{"id":"1","name":"Adair","state":"Oklahoma"}, {"id":"2","name":"Alfalfa","state":"Oklahoma"}, {"id":"3","name":"Atoka","state":"Oklahoma"}, {"id":"4","name":"Beaver","state":"Oklahoma"}, {"id":"5","name":"Beckham","state":"Oklahoma"}, {"id":"6","name":"Blaine","state":"Oklahoma"}, {"id":"7","name":"Bryan","state":"Oklahoma"}, {"id":"8","name":"Caddo","state":"Oklahoma"}, {"id":"9","name":"Canadian","state":"Oklahoma"}, {"id":"10","name":"Carter","state":"Oklahoma"}, {"id":"11","name":"Cherokee","state":"Oklahoma"}, {"id":"12","name":"Choctaw","state":"Oklahoma"}, {"id":"13","name":"Cimarron","state":"Oklahoma"}, {"id":"14","name":"Cleveland","state":"Oklahoma"}, {"id":"15","name":"Coal","state":"Oklahoma"}, {"id":"16","name":"Comanche","state":"Oklahoma"}, {"id":"17","name":"Cotton","state":"Oklahoma"}, {"id":"18","name":"Craig","state":"Oklahoma"}, {"id":"19","name":"Creek","state":"Oklahoma"}, {"id":"20","name":"Custer","state":"Oklahoma"}, {"id":"21","name":"Delaware","state":"Oklahoma"}, {"id":"22","name":"Dewey","state":"Oklahoma"}, {"id":"23","name":"Ellis","state":"Oklahoma"}, {"id":"24","name":"Garfield","state":"Oklahoma"}, {"id":"25","name":"Garvin","state":"Oklahoma"}, {"id":"26","name":"Grady","state":"Oklahoma"}, {"id":"27","name":"Grant","state":"Oklahoma"}, {"id":"28","name":"Greer","state":"Oklahoma"}, {"id":"29","name":"Harmon","state":"Oklahoma"}, {"id":"30","name":"Harper","state":"Oklahoma"}, {"id":"31","name":"Haskell","state":"Oklahoma"}, {"id":"32","name":"Hughes","state":"Oklahoma"}, {"id":"33","name":"Jackson","state":"Oklahoma"}, {"id":"34","name":"Jefferson","state":"Oklahoma"}, {"id":"35","name":"Johnston","state":"Oklahoma"}, {"id":"36","name":"Kay","state":"Oklahoma"}, {"id":"37","name":"Kingfisher","state":"Oklahoma"}, {"id":"38","name":"Kiowa","state":"Oklahoma"}, {"id":"39","name":"Latimer","state":"Oklahoma"}, {"id":"40","name":"LeFlore","state":"Oklahoma"}, {"id":"41","name":"Lincoln","state":"Oklahoma"}, {"id":"42","name":"Logan","state":"Oklahoma"}, {"id":"43","name":"Love","state":"Oklahoma"}, {"id":"44","name":"McClain","state":"Oklahoma"}, {"id":"45","name":"McCurtain","state":"Oklahoma"}, {"id":"46","name":"McIntosh","state":"Oklahoma"}, {"id":"47","name":"Major","state":"Oklahoma"}, {"id":"48","name":"Marshall","state":"Oklahoma"}, {"id":"49","name":"Mayes","state":"Oklahoma"}, {"id":"50","name":"Murray","state":"Oklahoma"}, {"id":"51","name":"Muskogee","state":"Oklahoma"}, {"id":"52","name":"Noble","state":"Oklahoma"}, {"id":"53","name":"Nowata","state":"Oklahoma"}, {"id":"54","name":"Okfuskee","state":"Oklahoma"}, {"id":"55","name":"Oklahoma","state":"Oklahoma"}, {"id":"56","name":"Okmulgee","state":"Oklahoma"}, {"id":"57","name":"Osage","state":"Oklahoma"}, {"id":"58","name":"Ottawa","state":"Oklahoma"}, {"id":"59","name":"Pawnee","state":"Oklahoma"}, {"id":"60","name":"Payne","state":"Oklahoma"}, {"id":"61","name":"Pittsburg","state":"Oklahoma"}, {"id":"62","name":"Pontotoc","state":"Oklahoma"}, {"id":"63","name":"Pottawatomie","state":"Oklahoma"}, {"id":"64","name":"Pushmataha","state":"Oklahoma"}, {"id":"65","name":"Roger Mills","state":"Oklahoma"}, {"id":"66","name":"Rogers","state":"Oklahoma"}, {"id":"67","name":"Seminole","state":"Oklahoma"}, {"id":"68","name":"Sequoyah","state":"Oklahoma"}, {"id":"69","name":"Stephens","state":"Oklahoma"}, {"id":"70","name":"Texas","state":"Oklahoma"}, {"id":"71","name":"Tillman","state":"Oklahoma"}, {"id":"72","name":"Tulsa","state":"Oklahoma"}, {"id":"73","name":"Wagoner","state":"Oklahoma"}, {"id":"74","name":"Washington","state":"Oklahoma"}, {"id":"75","name":"Washita","state":"Oklahoma"}, {"id":"76","name":"Woods","state":"Oklahoma"}, {"id":"77","name":"Woodward","state":"Oklahoma"}, {"id":"1","name":"Smith","state":"Texas"}]
    $scope.states = [
        {
            'name': 'Oklahoma'
        },
        {
            'name': 'Texas'
        }
    ]
    $scope.stateList = $scope.states[0];
});
