<?php namespace App\Http\Controllers;

use Response;
use App\Models\Game;
use App\Models\Theme;
use Auth;
use Mail;

class ConfigController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            try {

                //https://scotch.io/tutorials/ultimate-guide-on-sending-email-in-laravel        
                
      /*
      $data = array('name'=>Auth::user()->name, 'token'=>123);   
      Mail::send(['html'=>'emails.welcome'], $data, function($message) {
         $date = date("F j, Y, g:i:s a");
         $message->to(Auth::user()->email, Auth::user()->name)->subject('Starting game... '.Auth::user()->name.' '.$date);         
      });
      */         
                $res = Theme::all();
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
            //
        }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
 		//		
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//	
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
