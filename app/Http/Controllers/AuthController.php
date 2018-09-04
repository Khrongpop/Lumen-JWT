<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;


class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    } 

    public function index(){

      $user = User::get();
      return  $user;

    }

    public function register(Request $request){

      $user = User::checkEmailAndName($request)->first();
      if(!$user) {
        $user =  new User($request->all());
        //  $user->password =  app('hash')->make($request->password );
         $user->password =   Hash::make($request->password);
         $user->save();
         $user->token = $this->jwt($user);
        //  app('session')->put('token', $user->token);
         return response()->json($user, Response::HTTP_OK);
      } else return response()->json([ 'error' => 'already user.' ], 401);
      

    }


    public function login(Request $request){
      
        $user = User::checkEmailAndName($request)->first();
        $user->token = $this->jwt($user);
       
        if($user) {
          if(Hash::check($request->password, $user->getAuthPassword())) {
            // app('session')->put('token', $user->token);
            // dd(app('session')->all());
            return response(json_encode($user,JSON_NUMERIC_CHECK), Response::HTTP_OK);
          }
          else  {
            return response("invalid_pass",Response::HTTP_OK);
          }
        } else {
          return response("invalid_email",Response::HTTP_OK);
        }
          
    }


}
