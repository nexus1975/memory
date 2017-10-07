'use strict';

/* Services */

angular.module('MemoryApp.services', [])
    .value('version', '0.1')   
    .factory('ConfigService', function($http) {          
        var baseurl = 'api/config';
        return {
          getThemes: function() {
            return $http({
                url: baseurl,
                method: "GET"                
            }).
            success(function(data) {
                return data;
            });
          }
        };
    }) 
    .factory('PictureService', function($http) {          
        var baseurl = 'api/pictures';
        return {
          getPictures: function(theme) {
            return $http({
                url: baseurl+'?theme='+theme,
                method: "GET"                
            }).
            success(function(data) {
                return data;
            });
          }
        };
    })
    .factory('GameService', function($http) {          
        var baseurl = 'api/game';
        return {
          getGameParams: function(id) {
            return $http({
                url: baseurl+'/'+id,
                method: "GET"                
            }).
            success(function(data) {
                return data;
            });
          }
        };
    })
    .factory('BoardService', function($http) {          
        var baseurl = 'api/board';
        var params = {level: null, theme: null};
        return {
            setGameParams: function(level, theme) {
                params.level = level;
                params.theme = theme;
            },
            getGameParams: function(theme, level) {
                params.level = (params.level)?params.level:((level)?level:25);//default
                params.theme = (params.theme)?params.theme:((theme)?theme:'cities');//default
                return params;                
            },
            choosePicture: function(game_id, turn, col, row) {
              return $http({
                url: baseurl+'/0',
                method: "PUT",
                data: {
                    game_id: game_id,
                    turn: turn,
                    col: col, 
                    row: row,
                    direction: 'PICK'
                }
              }).
              success(function(data) {          
                  return data;
              });                       
            }, 
            takePictures: function(game_id, turn, cols, rows) {
              return $http({
                url: baseurl+'/0',
                method: "PUT",
                data: {
                    game_id: game_id,
                    turn: turn,
                    cols: cols, 
                    rows: rows,
                    direction: 'TAKE'
                }
              }).
              success(function(data) {        
                  return data;
              });                       
            },  
            backPictures: function(game_id, turn, cols, rows) {
              return $http({
                url: baseurl+'/0',
                method: "PUT",
                data: {
                    game_id: game_id,
                    turn: turn,
                    cols: cols, 
                    rows: rows,
                    direction: 'BACK'
                }
              }).
              success(function(data) {          
                  return data;
              });                       
            },          
            indexBoard: function() { 
              return $http({
                url: baseurl,
                method: "GET"              
              }).
              success(function(data) {
                  return data;
              });
            },     
            storeBoard: function(board, theme, level) {
              return $http({
                url: baseurl,
                method: "POST",
                data: {
                    board: board,
                    theme: theme,
                    level: level
                }
              }).
              success(function(data) {
                  return data;
              });  
            },          
            getBoard: function(game_id) {
              return $http({
                url: baseurl+'/'+game_id,
                method: "GET"              
              }).
              success(function(data) {
                  return data;
              });
            }
      };
    });

