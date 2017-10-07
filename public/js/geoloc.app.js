'use strict';

//GeolocApp module
angular.module('GeolocApp', [
    'ngRoute',  
    'ui.select', 'ngSanitize',
    'MemoryApp.directives.panel',
    'GeolocApp.controllers',
    'GeolocApp.controllers.panel',
    'GeolocApp.filters'
]).
config(['$routeProvider', function($routeProvider) {  
    $routeProvider.when('/map',      {templateUrl: 'partials/geoloc.map.html',     controller: 'GeolocCtrl'});
    $routeProvider.when('/devices',  {templateUrl: 'partials/geoloc.devices.html', controller: 'GeolocDevicesCtrl'});
    $routeProvider.when('/routes',   {templateUrl: 'partials/geoloc.routes.html',  controller: 'GeolocRoutesCtrl'});
    $routeProvider.when('/panel',    {templateUrl: 'partials/geoloc.panel.html',   controller: 'GeolocPanelCtrl'});
    $routeProvider.otherwise({redirectTo: '/map'});
}])
.controller('NavCtrl', ['$scope','$location', function($scope, $location) { 
    $scope.gotoDevices = function() {
        $location.path('/devices');
    };
    $scope.gotoRoutes = function() {
        $location.path('/routes');
    };
    $scope.gotoPanel = function() {
        $location.path('/panel');
    };    
    $scope.gotoMap = function() {
        $location.path('/map');
    };     
    $scope.logout = function() {            
        window.location = 'auth/logout';            
    };
}]);