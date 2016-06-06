/* global angular */
(function () {
    'use strict';
    angular
        .module('achimfritz.championshipApp')
        .service('ApiService', ApiService);

    /* @ngInject */
    function ApiService($http) {

        var self = this;
        var baseUrl = '/achimfritz.championship/';

        self.getTipGroups = getTipGroups;
        self.getMatches = getMatches;
        self.getUserTips = getUserTips;
        self.getMatchTips = getMatchTips;
        self.getUsers = getUsers;


        function getTipGroups() {
            var url = baseUrl + 'user/tipgroup/index';
            return $http({
                method: 'GET',
                url: url,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
        }

        function getMatches(cupId) {
            var url = baseUrl + 'competition/match/index?cup[__identity]=' + cupId;
            return $http({
                method: 'GET',
                url: url,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
        }

        function getUsers() {

        }

        function getUserTips(tipGroup, cupId) {

        }

        function getMatchTips($tipGroup, cupId) {

        }

    }
})();