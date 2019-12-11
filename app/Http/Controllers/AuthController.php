<?php

namespace App\Http\Controllers;

use App\User; 
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    public $successStatus = 200;
  
    public function register(Request $request) {    
    $validator = Validator::make($request->all(), 
                 [ 
                 'name' => 'required',
                 'email' => 'required|email',
                 'password' => 'required',  
                 'c_password' => 'required|same:password', 
                ]);   
    if ($validator->fails()) {          
          return response()->json(['error'=>$validator->errors()], 401);                       
    }    
    $input = $request->all();  
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input); 
    $success['token'] =  $user->createToken('AppName')->accessToken;
    return response()->json(['success'=>$success], $this->successStatus); 
   }
     
      
   public function login(Request $request){ 
    $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
      //'remember_me' => 'boolean'
    ]);
    $credentials = request(['email', 'password']);
      if(!Auth::attempt($credentials))
          return response()->json([
              'message' => 'Unauthorized'
          ], 401);
      $user = $request->user();
      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      if ($request->remember_me)
          $token->expires_at = Carbon::now()->addWeeks(1);
      $token->save();
      return response()->json([
          'access_token' => $tokenResult->accessToken,
          'token_type' => 'Bearer',
          'expires_at' => Carbon::parse(
              $tokenResult->token->expires_at
          )->toDateTimeString()
      ]);
   }
   public function logout(Request $request)
   {
       $request->user()->token()->revoke();
       return response()->json([
           'message' => 'Successfully logged out'
       ]);
   }
     
   public function getUser() {
    $user = Auth::user();
    return response()->json($user); 
    }
   
}
