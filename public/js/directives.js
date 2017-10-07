'use strict';

/* Directives */


angular.module('MemoryApp.directives', []).
  directive('appVersion', ['version', function(version) {
    return function(scope, elm, attrs) {
      elm.text(version);
    };
  }])
  .directive("flip", function($animate) {
  return {
    restrict : "E",
    controller: function($scope, $element, $attrs) {
      var elements = {
        'front': $element.find('flip-front'),
        'back': $element.find('flip-back')
      };
      $attrs.$observe('flipSide', function(visibleSide) {
        visibleSide = visibleSide || 'front';
        var otherSide = visibleSide === 'front' ? 'back' : 'front';
        $animate.removeClass(elements[otherSide], 'flip-visible');
        $animate.addClass(elements[visibleSide], 'flip-visible');
      });
    }
  }
});
;
