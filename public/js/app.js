'use strict';

//MemoryApp module
angular.module('MemoryApp', [
  'ngRoute',
  'ngAnimate',
  /*'chieffancypants.loadingBar',*/
  'angular-loading-bar',
  'MemoryApp.filters',
  'MemoryApp.services',
  'MemoryApp.directives',
  'MemoryApp.controllers'
]).
config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.includeSpinner = true;
    cfpLoadingBarProvider.parentSelector = '#loading-bar-container';
    cfpLoadingBarProvider.spinnerTemplate = '<div style="padding-top: 10px"><span class="fa fa-spinner"><img src="images/loading.strips.gif" width=60 height=27/></span></div>';
}).
config(['$routeProvider', function($routeProvider) {  
  $routeProvider.when('/',                  {templateUrl: 'partials/welcome.html', controller: 'WelcomeCtrl'});
  $routeProvider.when('/games',             {templateUrl: 'partials/games.html',   controller: 'GamesCtrl'});
  $routeProvider.when('/new/:level/:theme', {templateUrl: 'partials/game.html',    controller: 'GameCtrl'});
  $routeProvider.when('/game/:id/play',     {templateUrl: 'partials/game.html',    controller: 'GameCtrl'});
  $routeProvider.otherwise({redirectTo: '/'});
}]);
