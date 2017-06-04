<?php

namespace App\Http\Controllers;

use App\Badge;
use TCG\Voyager\Models\User;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as VoyagerBreadController;
use TCG\Voyager\Facades\Voyager;
class BadgeController extends VoyagerBreadController
{

    public function getAllBadge()
    {
        $badges = Badge::get();
        return response()->json($badges);
    }

    public function badgesByUser(Request $request)
    {
        $userId = $request->input('user_id');
        $badges = User::find($userId)->badges()->get();
        $response["data"] = $badges;
        return response()->json($response);
    }
   
}
