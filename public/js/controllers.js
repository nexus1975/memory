'use strict';

/* Controllers */

angular.module('MemoryApp.controllers', [])
    .constant('PARAMS', (function() {
        var size = 8;
        return {
            CONST_SIZE: size,
            CONST_TILES: size * size / 2,
            CONST_WAIT_SECONDS: 0.5 * 1000,
            BOARD_STATE_NORMAL: 0, 
            BOARD_STATE_UNSET: -1,
            BOARD_STATE_OPEN: 1,
            DEFAULT_LEVEL: 100, 
            DEFAULT_THEME: 'cities', 
            LEVELS: [{value: 25, label: 'Rookie'},
                     {value: 50, label: 'Normal'},
                     {value: 75, label: 'Advanced'},
                     {value: 100, label: 'Master'}]
        };
    }))  
    .controller('NavCtrl', ['$scope','$interval', function($scope, $interval) { 
/*
        var decreamentCountdown=function() {
            $scope.countdown -=1;
            if($scope.countdown<1) {
                window.location = 'auth/logout';
            }
        };
        var startCountDown=function() {
           $interval(decreamentCountdown,1000,$scope.countdown)
        };
        $scope.countdown = 60; //seconds === app/config/session.php
        //startCountDown();                


        window.addEventListener('resize', function(event){
           console.log('resize');
           console.log(screen.width);
           console.log(screen.height);
        });
*/
        $scope.logout = function() {            
            window.location = 'auth/logout';            
        };
    }])
    .controller('GamesCtrl', ['$scope','BoardService', function($scope, BoardService) { 
        BoardService.indexBoard().then(function(data){            
            $scope.games = data.data;                    
        });
    }])
    .controller('WelcomeCtrl', ['$scope','$location','PARAMS','ConfigService','BoardService', function($scope, $location, PARAMS, ConfigService, BoardService) {                       
        $scope.levels = PARAMS().LEVELS;               
        $scope.level = PARAMS().DEFAULT_LEVEL;                                            
        $scope.themes = [];
        $scope.theme = -1;
        $scope.loading = true;
     
        ConfigService.getThemes().then(function(data){                        
            $scope.themes = data.data;                        
            $scope.theme = PARAMS().DEFAULT_THEME;
            $scope.loading = false;
        });
        
        $scope.play = function() {
            BoardService.setGameParams($scope.level, $scope.theme);
            $location.path('/new/'+$scope.level+'/'+$scope.theme);            
        };        
        
    }])
    .controller('GameCtrl', ['$scope', '$routeParams','$location','$timeout','$filter','PARAMS','PictureService','GameService','BoardService', 
                     function($scope, $routeParams, $location, $timeout, $filter, PARAMS, PictureService, GameService, BoardService) {                     
        //Prepare game
        $scope.tiles = [];
        $scope.board = [];  
        $scope.pictures = [];
        $scope.memory = [];
        $scope.players = [];
        var rd = Math.floor((Math.random() * 32) + 1);
        var clickPossible = false;
        
        //utils
        function openTile(r, c) {
            $scope.board[r][c].state = PARAMS().BOARD_STATE_OPEN;
        }
        //Main function to play game
        function playGame(id) {           
            //Read board state from database and decide who is and how to play
            BoardService.getBoard(id).then(function(data){                        
                //Existing game ###priviliged
                $scope.board = data.data.board;
                if ($scope.board===undefined) { 
                    alert('We are sorry, but this board is not available. You will be redirected to start page.');
                    $location.path('/');
                    return;
                };                
                $scope.game = data.data.game;
               //background
                if ($scope.game.background==='') {                    
                    $scope.game.background = $scope.pictures[rd].img_src;
                } 
                $scope.players = data.data.players;
                $scope.memory = data.data.memory;
                $scope.levelname = $filter('filter')(PARAMS().LEVELS, $scope.game.level)[0].label; 
                
                //How many tiles are on the board
                if ($scope.game.tiles===0) {
                    $scope.message = 'Game over.';
                    $scope.game.turn = -1;                                        
                } else { 
                    if ($scope.game.turn===1) { //If 1 then Computer starts
                        clickPossible = false;
                        computerPlay();
                    } else { //user's turn
                        //Find uncovered tiles and check if the first is the only one?                        
                        var count = 0;
                        for(var r=0; r<PARAMS().CONST_SIZE; r++) {            
                            for(var c=0; c<PARAMS().CONST_SIZE; c++){
                                if ($scope.board[r][c].state > 0) {
                                    var tmp = { col: c, row: r, value: $scope.board[r][c].value };
                                    count++;
                                }
                            }
                        }
                        //There's only one tile uncovered
                        if (count === 1) {
                           $scope.first = tmp;
                           $scope.message = "Discover the second one...";
                        } else { //2 and 0 ?###
                           $scope.first = {col: null, row: null, value: null};
                           $scope.message = "It's your turn. Click to discover the first picture...";
                        }
                        //And waiting for user's 2nd move...
                        clickPossible = true;
                    }                    
                }                
            });
        };
        
        //Start a new game
        function newGame(params) {       
            
            function _GetTile() {                                        
                var ret = PARAMS().BOARD_STATE_UNSET;
                var tr = Math.floor(Math.random() * PARAMS().CONST_TILES);
                if ($scope.tiles[tr]>0) {
                    $scope.tiles[tr]--;
                    ret = tr;
                };                    
                return ret;
            }            

            function _FullFillBoard() {                     
                function _SetEmpty(tile) {
                    for(var i=0; i<PARAMS().CONST_SIZE; i++) {            
                        for(var j=0; j<PARAMS().CONST_SIZE; j++){
                            if ($scope.board[i][j].value === PARAMS().BOARD_STATE_UNSET) {
                                $scope.board[i][j] = { value: tile, state: PARAMS().BOARD_STATE_NORMAL };
                                $scope.tiles[tile]--;
                                return 0;
                            }
                        }
                    }
                }

                for(var i=0; i<PARAMS().CONST_TILES; i++) { 
                    var n = $scope.tiles[i];
                    for (var v=0; v<n; v++) {                                
                        _SetEmpty(i);
                    }
                }
            }            

            //Make a new board in client   
            for(var i=0; i < PARAMS().CONST_TILES; i++) { 
                $scope.tiles[i] = 2;
            }                                
            for(var i = 0; i < PARAMS().CONST_SIZE; i++) {   
                $scope.board.push([]);
                for(var j = 0; j < PARAMS().CONST_SIZE; j++){
                    $scope.board[i][j] = {value: _GetTile(), state: PARAMS().BOARD_STATE_NORMAL};
                }
            }  
            _FullFillBoard(); 

            //Store in database and play            
            BoardService.storeBoard($scope.board, params.theme, params.level).then(function(obj){                   
                $scope.game = obj.data.game;
                //previous call: playGame($scope.game.id); 
                $location.path('/game/'+$scope.game.id+'/play').replace();
            });
        };
        
        //Computer's move
        function computerPlay() {
            var MEMORY_UNKNOWN = -1;
            function guessUndiscovered() {
                undiscovered = [];
                for(var r=0; r<PARAMS().CONST_SIZE; r++) {
                    for(var c=0; c<PARAMS().CONST_SIZE; c++){     
                        if ($scope.memory[r][c] === MEMORY_UNKNOWN) { 
                            undiscovered.push( {row: r, col: c} );
                        }
                    }
                }
                var rnd = Math.floor(Math.random() * undiscovered.length);
                var tile = undiscovered[rnd];
                $scope.memory[tile.row][tile.col] = $scope.board[tile.row][tile.col].value;                 
                return tile;
            }
            function findInMemory() {
                //clear cache
                $scope.memoryCache = [];                     
                for(var t=0; t<PARAMS().CONST_TILES; t++) {
                        $scope.memoryCache[t] = { cols: [], rows: [] };
                }            
                //fill in cache
                for(var r=0; r<PARAMS().CONST_SIZE; r++) {
                    for(var c=0; c<PARAMS().CONST_SIZE; c++){     
                        if ($scope.memory[r][c] >= 0) {
                            $scope.memoryCache[$scope.memory[r][c]].cols.push(c);
                            $scope.memoryCache[$scope.memory[r][c]].rows.push(r);
                        }
                    }
                }
                //look up in cache...
                for (var i=0; i<$scope.memoryCache.length; i++) {
                    if ($scope.memoryCache[i].cols.length===2) {
                        $scope.message = 'Computer got a pair!';
                        openTile($scope.memoryCache[i].rows[0], $scope.memoryCache[i].cols[0]); //show picture
                        openTile($scope.memoryCache[i].rows[1], $scope.memoryCache[i].cols[1]); //show picture
                        return i;
                    }
                }
                return -1;
            }
            
            //start
            $scope.message = "Now computer plays...";
            clickPossible = false;           
            var undiscovered = [];
                                                
            //1. Check memory cache
            var f1 = findInMemory();
            if (f1>=0) {
                BoardService.takePictures($scope.game.id, $scope.game.turn, $scope.memoryCache[f1].cols, $scope.memoryCache[f1].rows).then(function(data){                                
                    $timeout(function(){
                        //keep on playing
                        playGame($scope.game.id); 
                    }, PARAMS().CONST_WAIT_SECONDS); 
                }); 
            } else {                       
                //2. Guess and choose first covered tile                        
                var tile1 = guessUndiscovered();                                     
                
                //3. Check memory cache again
                var f2 = findInMemory();
                if (f2>=0) {
                    BoardService.takePictures($scope.game.id, $scope.game.turn, $scope.memoryCache[f2].cols, $scope.memoryCache[f2].rows).then(function(data){                                
                        $timeout(function(){
                            //keep on playing
                            playGame($scope.game.id); 
                        }, PARAMS().CONST_WAIT_SECONDS); 
                    });                     
                } else {                          
                    //4. Guess again and choose second covered tile
                    var tile2 = guessUndiscovered();                                                  
                    openTile(tile1.row, tile1.col); //show picture
                    openTile(tile2.row, tile2.col); //show picture

                    //5. Check and finish
                    if ($scope.memory[tile1.row][tile1.col]===$scope.memory[tile2.row][tile2.col]) {
                        BoardService.takePictures($scope.game.id, $scope.game.turn, [tile1.col, tile2.col], [tile1.row, tile2.row]).then(function(data){                                
                            $timeout(function(){
                                //play again
                                playGame($scope.game.id);
                            }, PARAMS().CONST_WAIT_SECONDS); 
                        });                
                    } else {                                
                        BoardService.backPictures($scope.game.id, $scope.game.turn, [tile1.col, tile2.col], [tile1.row, tile2.row]).then(function(data){
                            $timeout(function(){
                                playGame($scope.game.id);
                            }, PARAMS().CONST_WAIT_SECONDS); 
                        }); 
                    }
                }                
            }
        };
        
        //User's move
        $scope.userPlay = function(row, col) {   
            if (clickPossible && $scope.board[row][col].state===0) {                
                clickPossible = false;                               
                openTile(row, col); //show picture
                
                BoardService.choosePicture($scope.game.id, $scope.game.turn, col, row).then(function(data){
                    if ($scope.first.col===null) {             
                        playGame($scope.game.id);
                    } else {                        
                        if ($scope.first.value===$scope.board[row][col].value) {                            
                            //trafiony
                            $scope.message = "Good. You got a pair!"; 
                            document.getElementById('good').play();
                            BoardService.takePictures($scope.game.id, $scope.game.turn, [$scope.first.col, col], [$scope.first.row, row]).then(function(data){                                
                                $timeout(function(){
                                    playGame($scope.game.id);
                                }, PARAMS().CONST_WAIT_SECONDS); 
                            });
                        } else {
                            //nietrafiony
                            $scope.message = "Wrong, maybe next time...";
                            document.getElementById('bad').play();
                            BoardService.backPictures($scope.game.id, $scope.game.turn, [$scope.first.col, col], [$scope.first.row, row]).then(function(data){
                                $timeout(function(){
                                    playGame($scope.game.id);
                                }, PARAMS().CONST_WAIT_SECONDS); 
                            });                            
                        }
                    };
                });            
            };
        };
        
        
        //css/classes
        $scope.flipSideTile = function(row,col) {
            return ($scope.board[row][col].state===1) ? 'back' : 'front';
        };       
        $scope.getImgSrc = function(board) {
            var img = $scope.pictures[board.value].img_src;
            return img;
        };
        $scope.getClassMemory = function(row, col) {            
                return ($scope.memoryCache && $scope.memory[row][col]>=0) ? (($scope.memoryCache[$scope.memory[row][col]].rows.length===2) ? 'memory2x' : 'memory') : '';
        };

        //--------------------------------------       
        $scope.main = function() {
            //GUI
            var aW = screen.availWidth;
            var aH = screen.availHeight;
            $scope.tileSize = Math.round((Math.min(aW, aH)*0.90)/8,0);
            //Start playing... 
            clickPossible = false;        
            if ($routeParams.id > 0) {
                GameService.getGameParams($routeParams.id).then(function(params){ 
                    $scope.level = params.data.level;
                    $scope.theme = params.data.theme;
                    PictureService.getPictures(params.data.theme).then(function(data){                               
                        $scope.pictures = data.data;                 
                        playGame($routeParams.id); 
                    });
                });
            } else {
                var params = BoardService.getGameParams($routeParams.theme, $routeParams.level);            
                $scope.level = params.level;
                $scope.theme = params.theme;
                PictureService.getPictures(params.theme).then(function(data){            
                    $scope.pictures = data.data;
                    newGame(params);
                });
            }
        };
        
        //run
        $scope.main();
     }]);
 //[eof]