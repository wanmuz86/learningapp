<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('email', $username)->first();
        if ($user) {
            $hashedPassword = Hash::make($password);
            if (Hash::check($password, $user->password)) {
                $response["status"] = "ok";
                $response["message"] = "user ok";
                $userInfo["name"] = $user["name"];
                $userInfo["email"] = $user["email"];
                $userInfo["avatar"] = "http://ec2-54-254-137-23.ap-southeast-1.compute.amazonaws.com/backend/storage/app/public/".$user["avatar"];
                $response["user"] = $userInfo;
                return response()->json($response);
            }
            else {
                $response["status"] = "error";
                $response["message"] = "wrong credential";
                return response()->json($response);
            }
        }
        $response["status"] = "error";
        $response["message"] = "user not exist";
        return response()->json($response);
    }
}
