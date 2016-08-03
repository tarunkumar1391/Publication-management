/**
 * Created by Haus-IT on 7/6/2016.
 */
var app = angular.module('myApp',[]);
app.controller('pubController',function ($scope,$http) {
    $http.get('../server/fetch.php').then(function (response) {
        $scope.entries = response.data.records;
        console.log($scope.entries);
    })
});
app.controller('pubmodController',function ($scope,$http) {
    $http.get('../server/fetch.php').then(function (response) {

        $scope.entries = response.data.records;

        $scope.rowClick = function(selectedRow){
            var rowData = [];
            $scope.rowData = selectedRow;
            // console.log($scope.rowData.Sno);
        }
       

    })
});