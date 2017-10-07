'use strict';

/* MemoryApp.directives.panel */

angular.module('MemoryApp.directives.panel', [])
.directive("ngRect", function() {
    console.log('directive4');
    return {
        restrict: 'E',
        replace: true,
        scope: {
            xAxis: '=',
            yAxis: '=',
            rectHeight: '=',
            rectWidth: '='
        },        
        templateNamespace: 'svg',
        templateUrl: 'partials/template.rect.html'
    };
});

//