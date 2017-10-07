<?php namespace App\Http\Controllers;

use Log;
use Request;
use Response;
use DateTime;
use App\Models\Geoloc;
use App\Models\Device;
use App\Models\UserDevice;
use App\Models\SavedRoute;
use App\Models\Place;
use Auth;
use DB;

class GeolocController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Geo Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('geoloc');
	}
        
        
        private function check() {
            $imei = Request::input('imei');
            if ($imei) {
                try {                                        
                    $device = Device::where('imei', '=', $imei)->get();
                    if (!$device->isEmpty()) {
                        $device = $device[0];
                        $clientdata = Request::input('clientdata') ? Request::input('clientdata') : 'WARN_NO_CLIENT_DATA';
                        if ($device->description !== $clientdata) {
                            $device->description = $clientdata;
                            $device->save();
                        }
                    } else {
                        return Response::json(Array("status"=>"ERROR", "No registered device with IMEI number ".$imei."."));
                    }
                    
                } catch (Exception  $e) {
                    return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
                }                
            } else {
                return Response::json(Array("status"=>"ERROR", "data"=>"No IMEI number. Cannot store location."));
            }                
        }
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
        
        private function int_save_place($imei, $userid, $name, $longitude, $latitude, $altitude) {
            try {
                if (substr($name,0,1) === ".") {
                                       
                    //$userid = Auth::user()->id; 
                    $places = Place::where('name', '=', substr($name,1))
                                    ->where('userid', '=', $userid)
                                    ->get();
                    if (count($places)===0) {
                        $place = new Place;
                        $place->userid = $userid;
                        $place->imei = $imei ? $imei : '#NO_IMEI#';
                        $place->longitude = $longitude;
                        $place->latitude = $latitude;
                        $place->altitude = $altitude;
                        $place->name = substr($name,1);
                        $place->save();                       
                    } else {                    
                        $place = $places[0];
                        $place->imei = $imei ? $imei : '#NO_IMEI#';
                        $place->longitude = $longitude;
                        $place->latitude = $latitude;
                        $place->altitude = $altitude;
                        $place->save();
                    }
                }  
            } catch (Exception $ex) {
                return Response::json(Array("status"=>"ERROR", "data"=>$ex->getMessage()));
            }
        }
        
	public function store()
	{            
            $this->check();
            try {                
                $userid = 1; //###!!!admin
                $imei = Request::input('imei');

                $geoloc = new Geoloc;
                $geoloc->imei = $imei ? $imei : '#NO_IMEI#';
                $geoloc->clientdata = 'online';
                $geoloc->serverdata = 'IP:'.Request::ip();
                $geoloc->longitude = Request::input('longitude') ? Request::input('longitude') : '0';
                $geoloc->latitude = Request::input('latitude') ? Request::input('latitude') : '0';
                $geoloc->altitude = Request::input('altitude') ? Request::input('altitude') : '0';
                $geoloc->accuracy = Request::input('accuracy') ? Request::input('accuracy') : '0';
                $geoloc->speed = Request::input('speed') ? Request::input('speed') : '0';
                $geoloc->bearing = Request::input('bearing') ? Request::input('bearing') : '0';
                $geoloc->name = Request::input('name');
                $geoloc->devicetime = Request::input('devicetime');
                $geoloc->save();                
                
                $this->int_save_place(
                    $imei, 
                    $userid, 
                    $geoloc->name, 
                    $geoloc->longitude, 
                    $geoloc->latitude, 
                    $geoloc->altitude
                );
                
                return Response::json($geoloc);

            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }                
        }  
        
	public function upload()
	{     
            $this->check();                        
            try { 
                DB::transaction(function() {
                    $imei = Request::input('imei');  
                    $userid = 1;//###!!!
                    $data = Request::input("geolocs");
                    $cnt = count($data);
                    for ($i=0; $i<$cnt; $i++) { 
                        $item = explode(",", substr($data[$i], 1, strlen($data[$i])-2));                        
//Log::info("longitude=".$item[0]);                  

                        $geoloc = new Geoloc;
                        $geoloc->imei = $imei ? $imei : '#NO_IMEI#';
                        $geoloc->clientdata = 'offline';
                        $geoloc->serverdata = 'IP:'.Request::ip();
                        $geoloc->longitude = $item[0] ? $item[0] : '0';
                        $geoloc->latitude = $item[1] ? $item[1] : '0';
                        $geoloc->altitude = $item[2] ? $item[2] : '0';
                        $geoloc->accuracy = $item[3] ? $item[3] : '0';
                        $geoloc->speed = $item[4] ? $item[4] : '0';
                        $geoloc->bearing = $item[5] ? $item[5] : '0';
                        $geoloc->name = $item[6];
                        $geoloc->devicetime = $item[7];
                        $geoloc->save(); 
                        
                        $this->int_save_place(
                            $imei, 
                            $userid, 
                            $geoloc->name, 
                            $geoloc->longitude, 
                            $geoloc->latitude, 
                            $geoloc->altitude
                        );
                    }
                    
                    
                    
                    $routes = Request::input("savedroutes");
                    $cnt = count($routes);
                    for ($i=0; $i<$cnt; $i++) { 
Log::info($routes[$i]);
                        $item = explode(",", substr($routes[$i], 1, strlen($routes[$i])-2));                        

                        $sr = new SavedRoute;
                        $sr->imei = $imei ? $imei : '#NO_IMEI#';
                        $sr->name = $item[0];
                        $sr->datefrom = $item[1];
                        $sr->dateto = $item[2];
                        $sr->distance =  $item[3];
                        $sr->distance2 =  $item[4];
                        $sr->pausetime =  $item[5];                        
                        $sr->save(); 
                    }                    
                });
                return Response::json(Array(
                    "status"=>"OK"
                ));   
            } catch (Exception $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
        }  
        
        /* Save user route */
	public function saveRoute()
	{            
            $this->check();
            try {                    
                $imei = Request::input('imei');
                $usr = new SavedRoute;
                $usr->imei = $imei ? $imei : '#NO_IMEI#';
                $usr->name = Request::input('name');                
                $usr->datefrom  = Request::input('datefrom');
                $usr->dateto  = Request::input('dateto');
                $usr->distance  = Request::input('distance');
                $usr->distance2  = Request::input('distance2');
                $usr->pausetime  = Request::input('pausetime');
                $usr->save(); 
                return Response::json(Array(
                    "status"=>"OK",
                    "route"=>$usr
                ));

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
	public function getdata($hours, $maxid)
	{
            try {
                $limit = 1000;
                $userid = Auth::user()->id;
                $now = date("Y-m-d H:i:s");
                $from = date('Y-m-d H:i:s', time() - $hours*3600);
                $to = $now;
                              
                $res = DB::select(
                    DB::raw('select g.*, d.description, ud.name
                               from geolocs g
                              inner join devices d on d.imei = g.imei
                              inner join userdevices ud on (ud.userid = :userid and ud.imei = d.imei)                              
                              where defaultdevice = 1
                                and g.devicetime between :from and :to
                                and g.id > :maxid
                              order by g.id asc
                              limit :limit'
                    ), 
                    array('userid'=> $userid,
                           'from' => $from, 
                             'to' => $to,
                          'maxid' => $maxid,
                          'limit' => $limit)
                );               
                return Response::json($res);
                
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
	public function panelData() {
            try {
                $limit = min(Request::input('limit'), 2000); 
                $userid = Auth::user()->id;
                
                $imei = Request::input('imei');
                $datefrom = new DateTime(Request::input('datefrom'));
                $dateto = new DateTime(Request::input('dateto'));
                              
                //$from = $datefrom->format('Y-m-d H:i:s');//+" "+$timefrom->format('H:i:s');
                //$to = $dateto->format('Y-m-d')+" "+$timeto->format('H:i:s');
                
                //return Response::json(array("from"=>$datefrom->format('Y-m-d H:i:s'),"to"=>$dateto->format('Y-m-d H:i:s')));
                
                $from = $datefrom->format('Y-m-d H:i:s');
                $to = $dateto->format('Y-m-d H:i:s');
                
                $metadata = DB::select(
                    DB::raw('select count(*) as cnt, max(altitude) as max_altitude, max(speed)*3600/1000 as max_speed,
                                    min(altitude) as min_altitude, min(speed)*3600/1000 as min_speed,
                                    min(devicetime) as min_devicetime, max(devicetime) as max_devicetime,
                                    TIMESTAMPDIFF(SECOND,min(devicetime),max(devicetime)) as span_devicetime,
                                    min(latitude) as min_lat, min(longitude) as min_lng,
                                    max(latitude) as max_lat, max(longitude) as max_lng
                               from geolocs g
                              inner join devices d on d.imei = g.imei
                              inner join userdevices ud on (ud.userid = :userid and ud.imei = d.imei)                              
                              where d.imei = :imei /*defaultdevice = 1*/
                                and g.devicetime between :from and :to'
                    ), 
                    array('userid'=> $userid,
                            'imei'=> $imei,
                            'from'=> $from,
                              'to'=> $to)
                );                
                
                $locations = [];
                if ($metadata) {
                    if ($metadata[0]->span_devicetime > 0 && $metadata[0]->cnt > 0) {                        
                        if ($metadata[0]->cnt <= $limit) {                            
                            $metadata[0]->section_width = 0;
                            $locations = DB::select(
                                DB::raw('select g.*, 
                                                speed as max_speed,
                                                null as min_latitude, null as min_longitude,
                                                null as max_latitude, null as max_longitude,
                                                ud.name, 
                                                round((TIMESTAMPDIFF(SECOND,:min_devicetime, g.devicetime)/:span_devicetime), 6) as rel_devicetime
                                           from geolocs g
                                          inner join devices d on d.imei = g.imei
                                          inner join userdevices ud on (ud.userid = :userid and ud.imei = d.imei)                              
                                          where d.imei = :imei /*defaultdevice = 1*/
                                            and g.devicetime between :from and :to
                                          order by g.devicetime asc'
                                ), 
                                array('userid'=> $userid,
                                        'imei'=> $imei,
                                        'from'=> $from,
                                          'to'=> $to,
                              'min_devicetime'=> $metadata[0]->min_devicetime,
                             'span_devicetime'=> $metadata[0]->span_devicetime)
                            );               
                        } else {
                            $metadata[0]->section_width = $metadata[0]->span_devicetime / $limit;
                            if ($metadata[0]->section_width > 0) {
                                $locations = DB::select(
                                    DB::raw('select round((TIMESTAMPDIFF(SECOND, :min_devicetime1, g.devicetime)/:section_width)) as section,
                                                avg(speed) as speed, avg(altitude) as altitude, 
                                                max(speed) as max_speed, max(altitude) as max_altitude, 
                                                round(avg(TIMESTAMPDIFF(SECOND, :min_devicetime2, g.devicetime)/:span_devicetime),6) as rel_devicetime,
                                                avg(latitude) as latitude, avg(longitude) as longitude,
                                                min(latitude) as min_latitude, min(longitude) as min_longitude,
                                                max(latitude) as max_latitude, max(longitude) as max_longitude
                                               from geolocs g
                                              inner join devices d on d.imei = g.imei
                                              inner join userdevices ud on (ud.userid = :userid and ud.imei = d.imei)                              
                                              where d.imei = :imei /*defaultdevice = 1*/
                                                and g.devicetime between :from and :to
                                              group by section
                                              order by 1'
                                    ), 
                                    array('userid'=> $userid,
                                            'imei'=> $imei,
                                            'from'=> $from,
                                              'to'=> $to,
                                   'section_width'=> $metadata[0]->section_width,
                                 'min_devicetime1'=> $metadata[0]->min_devicetime,
                                 'min_devicetime2'=> $metadata[0]->min_devicetime,
                                 'span_devicetime'=> $metadata[0]->span_devicetime)
                                ); 
                            }                           
                        }
                    }
                }
                return Response::json(
                    array("locations"=>$locations, 
                          "metadata"=>$metadata)
                );
                
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
	}  
        
        
        /*
	public function setDevice($imei)
	{
            try {
                $device = Device::where('imei', '=', $imei)
                                ->get();                 
                if (!$device->isEmpty()) {
                    $device = $device[0];
                    $device->description = "KNOWN";
                    $device->save();
                }
                return Response::json($imei);
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
	} 
        */
        public function getUserDevice(){
            try {
                $limit = 1000;
                $userid = Auth::user()->id;    
                $res = DB::select(
                    DB::raw('select ud.id, ud.imei, ud.name, d.description, ud.status, ud.created_at, ud.defaultdevice,
                                    d.created_at as device_created_at
                               from userdevices ud
                              inner join devices d on d.imei = ud.imei
                              where ud.userid = :userid
                              order by 1'
                    ), 
                    array('userid' => $userid)
                );
                return Response::json($res);
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
	}
        
        public function addUserDevice() {
            try {
                $userid = Auth::user()->id;                        
                $imei = Request::input('imei');
                //device
                $device = Device::where('imei', '=', $imei)->get();                 
                if ($device->isEmpty()) {
                    $device = new Device;
                    $device->imei = $imei;
                    $device->description = "NOT_KNOWN_YET";
                    //$device->status = 'PENDING';
                    $device->save();
                }
                
                //user device
                $ud = UserDevice::where('imei', '=', $imei)
                                ->where('userid', '=', $userid)
                                ->get();
                if ($ud->isEmpty()) {
                    $ud = new UserDevice;
                    $ud->imei = Request::input('imei');
                    $ud->name = Request::input('name');
                    //$ud->status = 'NEW';
                    $ud->userid = $userid;
                    $ud->save();
                }    
            } catch (Exception $ex) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
            return Response::json(array("device"=>$device));
        }

        public function deleteUserDevice($udid)
	{
            //return Response::json($udid);
            try {
                $userid = Auth::user()->id; 
                UserDevice::where('id', '=', $udid)
                           ->where('userid', '=', $userid)
                           ->delete();
                return Response::json($udid);
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
	}        

        public function setDefaultDevice($udid)
	{
            try {
                $userid = Auth::user()->id; 
                $ud = UserDevice::where('id', '=', $udid)
                                ->where('userid', '=', $userid)
                                ->get();
                if (!$ud->isEmpty()) {
                    $ud = $ud[0];
                    DB::update(
                        DB::raw('update userdevices
                                    set defaultdevice = 0
                                  where userid = :userid'
                        ), 
                        array('userid' => $userid)
                    );                    
                    $ud->defaultdevice = 1;
                    $ud->save();
                }
                return Response::json($ud);
            } catch (Exception  $e) {
                return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
            }
	}        
        
        public function getSavedRoutes() {
        try {
            $limit = 1000;
            $userid = Auth::user()->id;  
            $imei = Request::input('imei');
            $res = DB::select(
                DB::raw('select sr.id, sr.imei, trim(sr.name) as routename,
                                DATE_FORMAT(sr.datefrom, \'%M %Y\') as yearmonth,
                                DATE_FORMAT(sr.datefrom, \'%e, %W %H:%i\') as datefromdf, 
                                DATE_FORMAT(sr.dateto, \'%H:%i\') as datetodf,                                 
                                sr.datefrom, sr.dateto, 
                                sr.pausetime,
                                round(sr.distance,2) as distance, sr.distance2, 
                                ud.name as devicename
                           from savedroutes sr
                          inner join userdevices ud on sr.imei = ud.imei
                          inner join devices d on d.imei = ud.imei
                          where ud.userid = :userid
                            and d.imei = :imei
                          order by sr.dateto desc'
                ), 
                array('userid' => $userid, 'imei' => $imei)
            );
            return Response::json($res);
        } catch (Exception  $e) {
            return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
        }
    }    

//    Read particular route 
        public function getSavedRoute($srid) {
        try {
            $userid = Auth::user()->id;    
            $res = DB::select(
                DB::raw('select sr.id, sr.imei, trim(sr.name) as routename, 
                                sr.datefrom, sr.dateto, 
                                sr.pausetime,
                                sr.distance, sr.distance2, 
                                ud.name as devicename
                           from savedroutes sr
                          inner join userdevices ud on sr.imei = ud.imei
                          inner join devices d on d.imei = ud.imei                          
                          where ud.userid = :userid
                            and sr.id = :srid
                          order by sr.dateto desc'
                ), 
                array('userid' => $userid,
                        'srid' => $srid)
            );
            return Response::json($res[0]);
        } catch (Exception  $e) {
            return Response::json(Array("status"=>"ERROR", "data"=>$e->getMessage()));
        }
    }    

}
