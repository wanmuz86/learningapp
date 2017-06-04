<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuthExceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;
use Illuminate\Support\Facades\Hash;
class AuthenticateController extends Controller
{
    //

public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['authenticate', 'register']]);
   }

    public function authenticate(Request $request){
    	$credentials = $request->only('email', 'password');

    	try {
    		if (! $token = JWTAuth::attempt($credentials)){
    			return response()->json(['error'=> 'invalid credentials'], 401);
    		}

    	}
    	catch (JWTException $e){
    		return response()->json(['error' => 'could_not_create_token'], 500);
    	}
    	return response()->json(compact('token'));
    }
    public function index()
    {
    // Retrieve all the users in the database and return them
    $users = User::all();
    $user = Auth::user();
    return $user;
}

public function register(Request $request){
    $email = $request->input('email');
    $password = $request->input('password');
    $name = $request->input('name');
    $user = User::where('email', $email)->first();
    if ($user){
         $response["status"] = "ok";
         $response["message"] = "User already exists.";
        return response()->json($response);
    }
    else {
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();
        $response["status"] = "ok";
        return response()->json($response);
    }
}

}
