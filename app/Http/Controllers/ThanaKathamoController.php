<?php

namespace App\Http\Controllers;

use App\Models\BivagKathamo;

class ThanaKathamoController extends Controller
{
    public function index()
    {
        $results = BivagKathamo::get();
        return view('thana_kathamo', compact('results'));
    }
}
