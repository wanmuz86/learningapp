<?php

namespace App\Http\Controllers\Api;

use App\Badge;
use App\User;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as VoyagerBreadController;
use TCG\Voyager\Facades\Voyager;
use Auth;
class BadgeController extends VoyagerBreadController
{

 public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['getAllBadge']]);
   }

    public function getAllBadge()
    {
        $badges = Badge::get();
        return response()->json($badges);
    }

    public function badgesByUser(Request $request)
    {
        $userId = Auth::user()->id;
        $badges = User::where('id', $userId)->first()->badges()->get();
        $response["data"] = $badges;
        return response()->json($response);
    }
   
}
