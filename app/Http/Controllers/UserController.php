<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Hash;

class UserController extends Controller
{
    public function register(Request $request){
      
        $fields= Validator::make($request->all(),[
          'name' => 'required|string|max:255',
          'phone_number'=> 'required|max:9|min:9',
          'age'=> 'required',
          'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
          'id_photo' => 'required'
            
        ]);
        if($fields->fails()){
            return response()->json($fields->errors());
         //  return response()->json("failed");
        }
        try {
            $user= User::create([
                'name'=> $request->name,
                'phone_number'=> $request->phone_number,
                'age'=> $request->age,
                'password'=> Hash::make($request->password),
                'id_photo'=> $request->id_photo,
            ]);
        
        //  $token= $user->createToken('auth_token')->plainTextToken;
            
            return response()->json(['registration successful']);

        } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);
          
        }     
    }

    public function login(Request $request){
   
        $fields= Validator::make($request->all(),[
            'phone_number'=> 'required|max:9|min:9',
            'password'=> 'required|string'
              
          ]);
          if($fields->fails()){
              return response()->json($fields->errors());
          }
          $cradentials= ['phone_number'=> $request->phone_number, 'password'=> $request->password];

          try {
            if(!auth()->attempt($cradentials)){
                return response()->json(['error'=> 'phone number or password is incorrect']);
            }
            $user= User::where('phone_number', $request->phone_number)->firstOrFail();
            $token=$user->createToken('api')->plainTextToken;
            return response()->json(['login successfuly']);


          } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);
          }

    }

}
