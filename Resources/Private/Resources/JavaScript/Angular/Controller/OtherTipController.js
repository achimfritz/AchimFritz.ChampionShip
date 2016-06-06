/* global angular */
(function () {
    'use strict';
    angular
        .module('achimfritz.championshipApp')
        .controller('OtherTipController', OtherTipController);

    /* @ngInject */
    function OtherTipController ($scope, ApiService) {

        var cupId = $('#currentCup').data('cup');
        console.log(cupId);
        $scope.tipGroups = {};
        $scope.currentTipGroup = {};
        $scope.allMatches = [];
        $scope.currentMatch = {};
        $scope.users = {};
        $scope.currentUser = {};

        // view methods
        $scope.selectTipGroup = selectTipGroup;


        // internal methods
        this.init = init;

        init();


        function init() {
            ApiService.getTipGroups().then(
                function(data) {
                    $scope.tipGroups = data.data.tipGroups;
                    console.log($scope.tipGroups);
                    $scope.currentTipGroup = data.data.tipGroups[0];
                }, function() {

                }
            );
            ApiService.getMatches(cupId).then(
                function(data) {
                    $scope.allMatches = data.data.matches;
                    $scope.currentMatch = data.data.matches[0];
                    console.log($scope.allMatches);
                }, function() {

                }
            );
        }


        function selectTipGroup(tipGroup) {
            $scope.currentTipGroup = tipGroup;
        }
    }

})();