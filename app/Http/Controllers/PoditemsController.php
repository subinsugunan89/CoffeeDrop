<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Poditems;
use App\PodPriceDetails;
use App\Cashback_request;
use App\CashbackRequestProductDetails;
class PoditemsController extends Controller
{
    
    /**
     * Retrieve a quote.
     *
     * @param  \App\Poditems  
     * @return \Illuminate\Http\Response
     */
    public function quote(Request $request)
    {
      
        $pods_raw = $request->all();
		$totalAmount = 0;
    	 
        /**
         *Save the request & product details Into Database 
         */
        if($pods_raw){  
            $cashback_request = new Cashback_request;
            $cashback_request->userid   = 1;//$request->userid;  
            $cashback_request->save();
            $request_id=$cashback_request->id;
        }

    	foreach ($pods_raw as $pode_name => $totalCount) {

    		$product = Poditems::where('name',$pode_name)->first();

    		$item_price = PodPriceDetails::where('product_id',$product->id)
    		->orderBy('max_range_limit', 'asc')
    		->get();

            
             /**
             *Save the product details Into Database 
             */
            if($cashback_request->id){

                 $cashbackRequestProductDetails = new CashbackRequestProductDetails;
                 $cashbackRequestProductDetails->request_id   = $request_id;//$request->userid;  
                 $cashbackRequestProductDetails->product_id   = $product->id;//$request->userid; 
                 $cashbackRequestProductDetails->totalcount   = $totalCount;//$request->userid;   
                 $cashbackRequestProductDetails->save();             
            }



    		foreach ($item_price as $key => $rowvalue) {


	    			if($totalCount < $rowvalue->max_range_limit)
	                {
	                     $totalAmount = $totalAmount + ($totalCount * $rowvalue->price);
	                     $totalCount = 0;
	                    
	                }
	                else{
	                	 
	                      $totalAmount = $totalAmount + ($rowvalue->max_range_limit * $rowvalue->price);
	                      $totalCount = $totalCount - $rowvalue->max_range_limit;
	                }

    		}
    	}
    	  

    	$totalAmount=$totalAmount/100;

        return response()->json($totalAmount);
    }
}
