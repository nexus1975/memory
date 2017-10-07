'use strict';
    
angular.module('GeolocApp.services', [])
.factory('GeolocService', function($http) {          
    //var baseurl = 'ext/geoloc';    
    return {
        getGeolocData: function(maxID, hours) {
            return $http({
                url: 'geo/read/'+hours+'/'+maxID, 
                method: "GET"                
            })
            .success(function(data) {
                return data;
            });
        },
        getUserDevices: function() {
            return $http({
                url: 'geo/userdevice', 
                method: "GET"                
            })
            .success(function(data) {
                return data;
            });
        },
        addUserDevice: function(device) {
            return $http({
                url: 'geo/userdevice', 
                method: "POST",
                data: {
                    imei: device.imei, 
                    name: device.name
                }
            })
            .success(function(data) {
                return data;
            });
        },
        deleteUserDevice: function(udid) {
            return $http({
                url: 'geo/userdevice/'+udid, 
                method: "DELETE"                
            })
            .success(function(data) {
                return data;
            });
        },
        setDefaultDevice: function(udid) {
            return $http({
                url: 'geo/defaultdevice/'+udid, 
                method: "PUT"                
            })
            .success(function(data) {
                return data;
            });
        },
        getSavedRoutes: function(imei) {
            return $http({
                url: 'geo/savedroutes?imei='+imei, 
                method: "GET"                
            })
            .success(function(data) {
                return data;
            });
        },
        getSavedRoute: function(srid) {
            return $http({
                url: 'geo/savedroutes/'+srid, 
                method: "GET"                
            })
            .success(function(data) {
                return data;
            });
        },
        retrivePanelData: function(imei, datefrom, dateto, limit) {
            return $http({
                url: 'geo/panel', 
                method: "POST",
                data: {
                    imei: imei,
                    datefrom: datefrom, 
                    dateto: dateto,
                    limit: limit
                }
            })
            .success(function(data) {
                return data;
            });
        }
    };
});

angular.module('GeolocApp.controllers',['GeolocApp.services','GeolocApp.maps'])
.controller('GeolocCtrl', ['$scope', '$location', 'GeolocService', 'MapInitializer',function($scope, $location, GeolocService, MapInitializer) {
    $scope.geolocs = [];
    $scope.message = ''; 
    $scope.initiated = false;
    $scope.started = false;
    $scope.countDown = 10; //###
    $scope.hours = 1; 
    $scope.maxID = 0;
    var lastLat = null;
    var lastLng = null;
    var gl;  
    var cd;
    var map;
    var markers = [];
    var paths = [];
    var markerLastPosition = null;
    
    //maps
    // Adds a marker to the map and push to the array.
    function addMarker(geoloc) { 
        var marker = new google.maps.Marker({
            position: {lat: 1*geoloc.latitude, 
                       lng: 1*geoloc.longitude},
            map: map,
            icon: {
              path: google.maps.SymbolPath.CIRCLE,
              scale: 2, 
              fillColor: 'black',
              fillOpacity: 0.4,
              strokeColor: 'yellow',
              strokeWeight: 0
            },
            /*label: label,
            labelClass: 'labels',*/
            title: '#'+geoloc.id+':'+geoloc.clientdata,
            zIndex: 0
            
        });
        markers.push(marker);
    }
    function addLastPosition() { 
        if (markerLastPosition) {
            markerLastPosition.setPosition(new google.maps.LatLng(1*$scope.geolocs[$scope.geolocs.length-1].latitude, 1*$scope.geolocs[$scope.geolocs.length-1].longitude));
        } else {
            markerLastPosition = new google.maps.Marker({
                position: {lat: 1*$scope.geolocs[$scope.geolocs.length-1].latitude, 
                           lng: 1*$scope.geolocs[$scope.geolocs.length-1].longitude},
                map: map,
                icon: {
                  path: google.maps.SymbolPath.CIRCLE,
                  scale: 4, 
                  fillColor: 'red',
                  fillOpacity: 0.6,
                  strokeColor: 'yellow',
                  strokeWeight: 2
                },
                zIndex: 1
            });
            markers.push(markerLastPosition);            
        }    
    }
    function addPath(geoloc) {
        if (lastLat!==null && lastLng!==null) {
            /*
            var lineSymbol = {
                path: google.maps.SymbolPath.FORWARD_OPEN_ARROW
            };
            */
            var line = new google.maps.Polyline({
              path: [{lat: 1*lastLat, lng: 1*lastLng}, 
                     {lat: 1*geoloc.latitude, lng: 1*geoloc.longitude}],
              /*icons: [{
                icon: lineSymbol,
                offset: '100%'
              }],*/ 
              geodesic: true,
              strokeColor: '#666',
              strokeOpacity: 0.3,
              strokeWeight: 2,
              map: map
            });
            paths.push(line);
        }
    }
    
    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map); 
        }
        for (var i = 0; i < paths.length; i++) {
          paths[i].setMap(map);
        }        
    }
    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }
    // Shows any markers currently in the array.
    //function showMarkers() {
    //    setMapOnAll(map);
    //}
    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
        paths = [];
    }      
    //


    //    
    function showMap() {
        MapInitializer.mapsInitialized.then(function(){
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 51.13611791,
                    lng: 16.95349987
                },
                zoom: 16 
            });
            //            
            $scope.initiated = true;
            $scope.start(); 
        });
    }        
    
    //controller functions
    function getGeolocData(start) {     
        $scope.timeleft = $scope.countDown;
        $scope.message = 'Reading data...';
        
        GeolocService.getGeolocData($scope.maxID, $scope.hours).then(function(data){                   
                var newData = data.data;
                $scope.lastRefreshDate = null;
                
                $scope.message = 'Drawing...';                                 
                for (var i=0; i < newData.length; i++) {
                    //fill main array
                    $scope.geolocs.push(newData[i]);    
                    
                    //add mark on map
                    addMarker(newData[i]);  
                    addPath(newData[i]);
                    
                    //set maxID
                    if($scope.maxID < newData[i].id) $scope.maxID = newData[i].id;
                    lastLat = newData[i].latitude;
                    lastLng = newData[i].longitude;
                }                       

                if ($scope.geolocs.length > 0) {
                    if (start===1) map.setCenter(new google.maps.LatLng($scope.geolocs[$scope.geolocs.length-1].latitude, $scope.geolocs[$scope.geolocs.length-1].longitude));
                    addLastPosition();
                    $scope.lastRefreshDate = new Date();
                    $scope.message = ''+$scope.lastRefreshDate;
                } else {               
                    $scope.message = 'No recorded geolocations.';   
                }                      
                
                
        });
    }
    function getTimeleft() {
        //window.clearInterval(downloadTimer);
        $scope.$apply(function () {
            $scope.timeleft--;             
            if ($scope.timeleft === 0) {
               getGeolocData(0);
            }
        });   
    }

    //interactions
    $scope.onHoursChange = function () {
        $scope.maxID = 0;
        $scope.geolocs = [];
        markerLastPosition = null;
        deleteMarkers();
        getGeolocData();
    };
    
    $scope.start = function() {
        $scope.timeleft = $scope.countDown;
        getGeolocData(1);        
        $scope.resume();
    };
    
    $scope.resume = function() {                
        //gl = window.setInterval(getGeolocData, $scope.countDown*1000);        
        cd = window.setInterval(getTimeleft, 1000);
        $scope.message = '';
        $scope.pauseResumeLabel = 'Pause'; //&#x23F8
        $scope.started = true;
    };
    $scope.pause = function() {
        //window.clearInterval(gl);
        window.clearInterval(cd);
        $scope.message = 'Paused';
        $scope.pauseResumeLabel = 'Play';
        $scope.started = false;
    };
    $scope.pauseResume = function() {
        if ($scope.started) {
            $scope.pause();
        } else {
            $scope.resume();
        }
    };
    
    //MAIN
    $scope.message = 'Initialing...';    
    showMap();   
    
    //###OLD
    $scope.storeGeoloc = function() { 
        var geoloc = JSON.stringify(navigator.userAgent+' '+navigator.product+' '+navigator.appVersion );
        console.log('geolocctrl:'+geoloc);
        //alert(0);
        GeolocService.storeGeoloc(geoloc).then(function(obj){                   
                console.log('geoloc.callback');
        });
    };
}])

.controller('GeolocDevicesCtrl', ['$scope', '$location', 'GeolocService', 'MapInitializer',function($scope, $location, GeolocService) {        
    $scope.refreshDeviceList = function() {
        $scope.devices = [];
        $scope.device = {
            imei: '', name: ''
        };
        GeolocService.getUserDevices().then(function(data){
            $scope.devices = data.data;
        });
    };
    $scope.refreshDeviceList();
    
    //interactions
    $scope.addNewDevice = function() {
        if ($scope.device.imei!=='' && $scope.device.name!=='') {
            GeolocService.addUserDevice($scope.device).then(function(data){
                $scope.refreshDeviceList();
            });
        };
    };
    $scope.deleteUserDevice = function(udid) {
        GeolocService.deleteUserDevice(udid).then(function(data){
           $scope.refreshDeviceList(); 
        });
    };
    $scope.setDefaultDevice = function(udid) {
//console.log('default='+udid);
        GeolocService.setDefaultDevice(udid).then(function(data){
           //$scope.refreshDeviceList(); 
        });
    };    
    $scope.gotoMap = function() {
        $location.path('/map');
    }; 
}])

.controller('GeolocRoutesCtrl', ['$scope', '$location', 'GeolocService', 'MapInitializer',function($scope, $location, GeolocService) {        
    $scope.refreshRouteList = function() {
        $scope.routes = [];

        GeolocService.getSavedRoutes().then(function(data){ //###ERROR getSavedRoutes needs param
            $scope.routes = data.data;
        });
        $scope.getDate = function (date) {
            if (date) {
                return new Date(date);
            } else {
                return "";
            };
        };   
        $scope.toTimeString = function(seconds) {
            return (new Date(seconds * 1000)).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0];
        };
        $scope.getLength = function(date1, date2) {
            return (new Date(date2) - new Date(date1))/1000;
        };
    };
    $scope.refreshRouteList();
    
    //interactions        
    $scope.gotoMap = function() {
        $location.path('/map');
    }; 
}])

angular.module('GeolocApp.filters', []).
filter('formatDateTime', function ($filter) {
    console.log('formatDateTime');
    return function (date, format) {
        if (date) {
            return $filter('date')(date,'EEE');
        } else {
            return "";
        };
    };
});
/*
function showMap(position) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            },
            zoom: 16 
        }); 
        GeolocService.getGeoloc().then(function(data){   
                $scope.geolocs = data.data;                      
                drawMarks();
        });
    }    
    function initMap() {
        if (navigator.geolocation) {
            $scope.message = 'InitMap.getCurrentPosition...';
            navigator.geolocation.getCurrentPosition(showMap);
        } else {
            console.log("Geolocation is not supported by this browser.");
            $scope.message = 'Geolocation is not supported by this browser.'; 
        }    
    } 
 function showLocationOLD(position) {
//console.log("Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude); 
$scope.message = "Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude;
        var geoloc = JSON.stringify(navigator.userAgent+' '+navigator.product+' '+navigator.appVersion );
//console.log('GeolocService.storeGeoloc:'+geoloc);
$scope.message = 'GeolocService.storeGeoloc:'+geoloc;
        //alert(0);
        GeolocService.storeGeoloc(geoloc, position.coords.longitude, position.coords.latitude).then(function(obj){                   
                //console.log('OK.GeolocService.storeGeoloc.callback');
                $scope.message = 'GeolocService.storeGeoloc.callback.OK';
                
                GeolocService.getGeoloc().then(function(data){   
                   // $scope.$apply(function () {
                        $scope.geolocs = data.data;  
                        drawMarks();
                   // });
                }); 
                
        });        
    }
    //controller functions
    function showGeoloc(position) {
//console.log("Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude); 
$scope.message = "Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude;
        var geoloc = JSON.stringify(navigator.userAgent+' '+navigator.product+' '+navigator.appVersion );
//console.log('GeolocService.storeGeoloc:'+geoloc);
//$scope.message = 'GeolocService.storeGeoloc:'+geoloc;
        //alert(0);

 
                
       
    }
    function getLocationOLD() {     
        $scope.message = 'getLocation()';
        $scope.timeleft = $scope.countDown;
        if (navigator.geolocation) {
            $scope.message = 'getCurrentPosition...';
            navigator.geolocation.getCurrentPosition(showLocation);
        } else {
            console.log("Geolocation is not supported by this browser.");
            $scope.message = 'Geolocation is not supported by this browser.'; 
        }
    }
    
    
    .factory('GeolocService', function($http) {          
    var baseurl = 'ext/geo';
    //var params = {level: null, theme: null};
    return {
        storeGeoloc: function(clientdata, longitude, latitude) {
            return $http({
              url: baseurl,
              method: "POST",
              data: {
                  clientdata: 'geoloc.js:'+clientdata,
                  longitude: longitude,
                  latitude: latitude
              }
            })
            .success(function(data) {
                return data;
            });  
        },
        getGeoloc: function() {
            return $http({
                url: baseurl+'/0',
                method: "GET"                
            }).
            success(function(data) {
                return data;
            });
          }
    };
});
    
 * /
 */