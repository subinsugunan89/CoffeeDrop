<?php

namespace App\Http\Controllers;
use App\Location;
use App\LocationOpeningDetails;
use Illuminate\Http\Request;
use DB;

class LocationController extends Controller
{
    public function index(){ 
		return Location::all();
    }

    public function getNearestLocation(Request $request){

    	$postcode = $request->postcode;
 		$postcodeDetails=$this->getpostcodesDetails($postcode);

        if (count($postcodeDetails) == 0) { 	
      	 return response()->json('Postcode not Valid ,Please check the given postcode');
        }else{

        $latitude=$postcodeDetails['lat'];
        $longitude=$postcodeDetails['lng'];
        $radius = 1500;

        //https://stackoverflow.com/questions/27708490/haversine-formula-definition-for-sql
       
        $closet_location = Location::select('*')
            ->selectRaw('( 3959 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance,status AS locationstatus', [$latitude, $longitude, $latitude])
            ->havingRaw("distance < ? AND locationstatus = ?", [$radius,'1'])->orderBy('distance')
            ->first();

       
	            if(isset($closet_location->latitude)) {

					$locationDetails['location_refference_ID']=$closet_location->id;
					$locationDetails['postcode']=$closet_location->postcode;
					$locationDetails['contact_number']=$closet_location->contact_number;
					$locationDetails['address_line1']=$closet_location->address_line1;
					$locationDetails['address_line2']=$closet_location->address_line2;
					$locationDetails['location_name']=$closet_location->location_name;


					$location_opening_details = DB::table('location AS l')
		            ->leftJoin('location_opening_details AS ld', 'l.id', '=', 'ld.location_id')
		            ->select('ld.day','ld.open_time','ld.closesing_time')
		            ->where('l.id', '=', 4)
		            ->orderBy('l.id', 'DESC')
		            ->get();

		           if($location_opening_details){
		             	$locationDetails['location_opening_details']=$location_opening_details;
		          	 }

		          	 return response()->json($locationDetails);

	      		}
        }//Else Close

        return response()->json('Doest not have any location near by your location');
	     
    }

    public function getpostcodesDetails($postcode)
    {
    	
    	$return=array();
    	try{
              $client = new \GuzzleHttp\Client();     
              $request = $client->get('https://api.postcodes.io/postcodes/'.$postcode);
              $response = json_decode($request->getBody()->getContents(),true);
              $return['lat'] = $response['result']['latitude'];
              $return['lng'] = $response['result']['longitude'];

        }
        catch(\Exception $e)
        {
            $return=array();
        }

        return $return;
    }

     /**
     * Create a newly created location  into Database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function  createNewLocation(Request $request)
    {
 			$this->validate($request,[
            'postcode' =>'required',
            ]);
 $postcodeDetails=$this->getpostcodesDetails($request->postcode);

 if (count($postcodeDetails) == 0) { 	
      	 return response()->json('Postcode not Valid ,Please check the given postcode');
        }
        else{

        	$addLocation = new Location;
	        $addLocation->postcode   = $request->postcode;//$request->name;  
	        $addLocation->latitude   = $postcodeDetails['lat'];
	        $addLocation->longitude   = $postcodeDetails['lng'];
	        $addLocation->contact_number   = "";
	        $addLocation->address_line1   = "";
	        $addLocation->address_line2   = "";
	        $addLocation->location_name   = "";
	        $addLocation->save();
        }

        if($addLocation->id){

        	$location_opening_details=$request->opening_times;
        	$location_closing_times_details=$request->closing_times;

        	foreach ($location_opening_details as $key => $value) {

        			$addLocationOpeningDetails = new LocationOpeningDetails;
			        $addLocationOpeningDetails->day   = $key;//$request->name;  
			        $addLocationOpeningDetails->open_time   = $value;	
			        if (isset($location_closing_times_details[$key])) {

			       		$addLocationOpeningDetails->open_time   = $location_closing_times_details[$key];	
			        }
			        $addLocationOpeningDetails->location_id   = $addLocation->id;		        
			        $addLocationOpeningDetails->save();
        	
        	}

        }
        return response()->json(array('success' => true, 'location_refference_ID' => $addLocation->id), 200);
       

    }

}
