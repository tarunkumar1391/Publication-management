/**
 * Created by Haus-IT on 7/6/2016.
 */
var app = angular.module('myApp',['ui.bootstrap','ngAnimate']);
app.controller('pubController',function ($scope,$http) {
    $scope.tow = [
        {id : "1", work : "MSc-Thesis"},
        {id : "2", work : "MSc-Proposal"},
        {id : "3", work : "BSc-Thesis"},
        {id : "4", work : "Dissertation"},
        {id : "5", work : "Miniforsch."},
        {id : "6", work : "Project-Proposal"},
        {id : "7", work : "Diplom-Arbeit"},
        {id : "8", work : "Forsch.arb."},
        {id : "9", work : "Research project"}
    ];
    $scope.foerd = [
        {id : "1", foer : "Keine"},
        {id : "2", foer : "SFB 634"},
        {id : "3", foer : "BMBF"},
        {id : "4", foer : "DFG"},
        {id : "5", foer : "HIC for FAIR."},
        {id : "6", foer : "EMMI"},
        {id : "7", foer : "Other"},
    ];
    $scope.tp = [
        {id : "1", typ : "None"},
        {id : "2", typ : "A1"},
        {id : "3", typ : "A2"},
        {id : "4", typ : "B1"},
        {id : "5", typ : "B2"},
        {id : "6", typ : "B3"},
        {id : "7", typ : "B4"},
        {id : "8", typ : "C1"},
        {id : "9", typ : "C2"},
        {id : "10", typ : "C3"},
        {id : "11", typ : "C4"},
        {id : "12", typ : "D1"},
        {id : "13", typ : "D2"},
        {id : "14", typ : "D3"},
        {id : "15", typ : "D4"},
        {id : "16", typ : "E1"},
        {id : "17", typ : "E2"},
        {id : "18", typ : "E3"},
        {id : "19", typ : "E4"}
    ];
    $http.get('../server/fetch.php').then(function (response) {
        $scope.entries = response.data.records;
        console.log($scope.entries);
    })
});
app.controller('pubmodController',function ($scope,$http,$uibModal, $log) {
    $scope.typofwork = [
        {id : "1", type : "MSc-Thesis"},
        {id : "2", type : "MSc-Proposal"},
        {id : "3", type : "BSc-Thesis"},
        {id : "4", type : "Dissertation"},
        {id : "5", type : "Miniforsch."},
        {id : "6", type : "Project-Proposal"},
        {id : "7", type : "Diplom-Arbeit"},
        {id : "8", type : "Forsch.arb."},
        {id : "9", type : "Research project"}
    ];
    $scope.foerderung = [
        {id : "1", type : "Keine"},
        {id : "2", type : "SFB 634"},
        {id : "3", type : "BMBF"},
        {id : "4", type : "DFG"},
        {id : "5", type : "HIC for FAIR."},
        {id : "6", type : "EMMI"},
        {id : "7", type : "Other"},
    ];
    $scope.tp = [
        {id : "1", type : "None"},
        {id : "2", type : "A1"},
        {id : "3", type : "A2"},
        {id : "4", type : "B1"},
        {id : "5", type : "B2"},
        {id : "6", type : "B3"},
        {id : "7", type : "B4"},
        {id : "8", type : "C1"},
        {id : "9", type : "C2"},
        {id : "10", type : "C3"},
        {id : "11", type : "C4"},
        {id : "12", type : "D1"},
        {id : "13", type : "D2"},
        {id : "14", type : "D3"},
        {id : "15", type : "D4"},
        {id : "16", type : "E1"},
        {id : "17", type : "E2"},
        {id : "18", type : "E3"},
        {id : "19", type : "E4"}
    ];

    $http.get('../server/fetch.php').then(function (response) {

        $scope.entries = response.data.records;

        $scope.animationsEnabled = true;
        $scope.open = function(size){

            $scope.items = this.entry;
            console.log($scope.items);


            var modalInstance = $uibModal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'pubmodmodal.html',
                controller: 'ModalInstanceCtrl',
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };

        $scope.toggleAnimation = function () {
            $scope.animationsEnabled = !$scope.animationsEnabled;
        };

    });
});
app.controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, items) {

    $scope.items = items;


    $scope.ok = function () {
        $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});