<?php namespace App\Http\Controllers;

use Request;
use Response;
use App\Models\Board;
use App\Models\Game;
use App\Models\Memory; 
use App\Models\Player;
use Auth;
use Mail;

class BoardsController extends Controller {
        private $CONST_SIZE = 8;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            try {
                $res = Game::all();
                return Response::json($res);
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }                            
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            //void
        }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            try {
                //$data = Input::all();
                //New Game
                $game = new Game;
                $game->name = "New memory game";    
                $game->tiles = $this->CONST_SIZE * $this->CONST_SIZE / 2; 
                $game->turn = 2; //user starts //floor(rand(1,2)); //random who starts the first
                $game->level = Request::input('level');
                $game->theme = Request::input('theme');
                $game->background = ($game->theme=='numbers'?'background.png':'');
                $game->save(); 
                
                //Players
                for ($p=1; $p<=2; $p++) {                    
                    $player = new Player;
                    $player->name = ($p===1) ? 'Computer' : (Auth::user()->name);
                    $player->num = $p;
                    $player->game_id = $game->id; 
                    $player->score = 0; 
                    $player->missed = 0; 
                    $player->save();
                }
                //Board and computer memory
                $board = Request::input('board');            
                for($i = 0; $i < $this->CONST_SIZE; $i++) {            
                    for($j = 0; $j < $this->CONST_SIZE; $j++) {
                        //board
                        $b = new Board;
                        $b->game_id = $game->id;                                                       
                        $b->element_row = $i;                
                        $b->element_col = $j; 
                        $b->value = $board[$i][$j]['value'];                
                        $b->state = $board[$i][$j]['state']; 
                        $b->save();
                        
                        //computer memory
                        $m = new Memory;
                        $m->game_id = $game->id;                                                       
                        $m->element_row = $i;                
                        $m->element_col = $j; 
                        $m->value = -1; //UNKNOWN
                        $m->save();
                    }
                } 
                
                $data['email'] = Auth::user()->email;
                $data['name'] = Auth::user()->name;
                $data['id'] = $game->id;
                $data['game'] = '#'.$game->id.'/'.$game->theme.'/'.$game->level;
                Mail::send(['html'=>'emails.started'], $data, function($message) use ($data) {
                    //$date = date("F j, Y, g:i:s a");
                    $message->to($data['email'], $data['name'])->subject('Started Memory Game '.$data['game']); 
                });
                return Response::json(Array("game"=>$game));
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }  				
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
            try {
                $game = Game::where('id', '=', $id)->get();     
                $players = Player::where('game_id', '=', $id)->get();                
                $board = array();
                $res = Board::where('game_id', '=', $id)->get();                
                foreach ($res as $b) {
                    $board[$b->element_row][$b->element_col]['value'] = $b->value;                    
                    $board[$b->element_row][$b->element_col]['state'] = $b->state;
                    $board[$b->element_row][$b->element_col]['user'] = $b->user;
                };                                            
                $res2 = Memory::where('game_id', '=', $id)->get();
                $memory = array();
                foreach ($res2 as $m) {
                    $memory[$m->element_row][$m->element_col] = $m->value;
                };   

                $ret = Array('board'=>$board, 'memory'=>$memory, 'game'=>$game[0], 'players'=>$players);
                return Response::json($ret);
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            try {
                $res = Board::findOrFail($id);
                return Response::json($res);
            } catch (Exception  $e) {
                return Response::json($e->getMessage());
            }
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            try {                
                $Game = Game::find(Request::input('game_id'));
                //show, uncover
                if (Request::input('direction') === 'PICK') {
                    $res = Board::where('game_id', '=', Request::input('game_id'))
                                ->where('element_col', '=', Request::input('col'))
                                ->where('element_row', '=', Request::input('row'))
                                ->get();  
                    $id = $res[0]['id'];
                    $Board = Board::find($id);
                    $Board->state = 1; //open
                    $Board->save();
                }                        

                //miss, return back
                if (Request::input('direction') === 'BACK') {
                    for ($i=0; $i<=1; $i++) {
                        //board
                        $res = Board::where('game_id', '=', Request::input('game_id'))
                                    ->where('element_col', '=', Request::input('cols')[$i])
                                    ->where('element_row', '=', Request::input('rows')[$i])
                                    ->get();          
                        $bid = $res[0]['id'];
                        $Board = Board::find($bid);
                        $Board->state = 0; //normal
                        $Board->save(); 

                        //computer memory
                        $mem = Memory::where('game_id', '=', Request::input('game_id'))
                                    ->where('element_col', '=', Request::input('cols')[$i])
                                    ->where('element_row', '=', Request::input('rows')[$i])
                                    ->get(); 

                        //computer will remember the tile based on game level                                                                                        
                        $m = Memory::findOrFail($mem[0]['id']);                        
                        $rnd = rand(0,100);
                        if ($rnd <= min($Game->level + $m->hits * 10, 100)) { //previous hits increase ratio by 10%
                            $m->value = $Board->value;          
                        }
                        $m->hits++;
                        $m->save();                                   
                    }

                    //increase missed
                    $pl = Player::where('game_id', '=', Request::input('game_id'))
                                ->where('num','=',Request::input('turn'))
                                ->get(); 
                    $Player = Player::find($pl[0]['id']);
                    $Player->missed += 1; 
                    $Player->save();

                    //change turn
                    $Game->turn = (($Game->turn===1) ? 2 : 1); 
                    $Game->save();
                }

                //hit, take off the board
                if (Request::input('direction') === 'TAKE') {    
                    for ($i=0; $i<=1; $i++) {
                        //board
                        $res = Board::where('game_id', '=', Request::input('game_id'))
                                    ->where('element_col', '=', Request::input('cols')[$i])
                                    ->where('element_row', '=', Request::input('rows')[$i])
                                    ->get();          
                        $bid = $res[0]['id'];
                        $Board = Board::find($bid);
                        $Board->state = -1; //taken, off the board
                        $Board->user = Request::input('turn');
                        $Board->save(); 

                        //computer memory
                        $mem = Memory::where('game_id', '=', Request::input('game_id'))
                                    ->where('element_col', '=', Request::input('cols')[$i])
                                    ->where('element_row', '=', Request::input('rows')[$i])
                                    ->get();                                          
                        $m = Memory::findOrFail($mem[0]['id']);
                        $m->value = -2; //taken, not relevant any longer for computer memory
                        $m->save();                                                                    
                    }

                    //increase score
                    $pl = Player::where('game_id', '=', Request::input('game_id'))
                                    ->where('num','=',Request::input('turn'))
                                    ->get(); 
                    $Player = Player::find($pl[0]['id']);
                    $Player->score += 1; 
                    $Player->save();

                    //update tiles left on the board
                    $Game = Game::find(Request::input('game_id'));
                    $Game->tiles -= 1; 
                    $Game->save();
                }                                                    
		return Response::json(null);
            } catch (Exception  $e) {
                return Response::json($e->getMessage());
            }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            //void
	}
}
