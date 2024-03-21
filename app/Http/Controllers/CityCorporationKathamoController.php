<?php

namespace App\Http\Controllers;

use App\Models\BivagKathamo;

class CityCorporationKathamoController extends Controller
{

    public function index()
    {
        $results = BivagKathamo::get();
        return view('city_corporation_kathamo', compact('results'));
    }
}
