<?php

namespace App\Http\Controllers;

use App\Models\BivagKathamo;

class UnionKathamoController extends Controller
{
    public function index()
    {
        $results = BivagKathamo::get();
        return view('union_kathamo', compact('results'));
    }
}
