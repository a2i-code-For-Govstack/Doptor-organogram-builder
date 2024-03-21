<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{

    public function loginTracking()
    {
        return view('tracking.login_tracking');
    }

    public function loadLoginHistory(Request $request)
    {
        $histories = DB::table('user_login_history')->where('office_unit_id', $request->office_unit_id)->get();
        return view('tracking.login_tracking_history', compact('histories'));
    }
}
