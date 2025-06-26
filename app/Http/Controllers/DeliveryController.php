<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    public function addCard(Request $request){

    $user= Auth::user();

    $fields= Validator::make($request->all(),[
            'card_number' => 'required',
            'owner_name' => 'required',
            'CVV' => 'required|min:3|max:3',
            'expiery_date' => 'required', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/',
            
        ]);
      
           if($fields->fails()){
            return response()->json($fields->errors());
        }
        try {
            
         $card = new Card([
        'card_number' => $request->card_number,
        'owner_name' => $request->owner_name,
        'CVV' => $request->CVV,
        'expiery_date' => $request->expiery_date,
    ]);
    $request->user()->cards()->save($card);

    return response()->json(['message' => 'Card added successfully']);
    //return response()->json(['message' => 'Card added successfully', 'card' => $card]);

        } catch (\Exception $exception) {

    return response()->json(['error'=>$exception->getMessage()]);
   }

    }

    public function addDeliveryAddress(Request $request){
     
        $user= Auth::user();

    $fields= Validator::make($request->all(),[
            'governorate' => 'required',
            'city' => 'required',
            'street' => 'required',
            'building_number' => 'required',
            'delivery_time' => 'required',
            ]);
       if($fields->fails()){
            return response()->json($fields->errors());
        }

        try {
            
       $delivery = new Delivery([
        'governorate' => $request->governorate,
        'city' => $request->city,
        'street' => $request->street,
        'building_number' => $request->building_number,
        'delivery_time' => $request->delivery_time,
    ]);
    $request->user()->deliveryAddress()->save($delivery);

    return response()->json(['message' => 'Address added successfully']);
   // return response()->json(['message' => 'Address added successfully', 'address' => $delivery]);

        } catch (\Exception $exception) {

    return response()->json(['error'=>$exception->getMessage()]);
   }


       
    }
}
