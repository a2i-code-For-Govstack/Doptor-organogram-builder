<?php

namespace App\Http\Controllers;

use App\Models\BivagKathamo;
use App\Models\PostOfficeKathamo;
use App\Models\UpoZilaKathamo;
use App\Models\ZilaKathamo;
use Illuminate\Http\Request;

class PostOfficeKathamoController extends Controller
{
    public function index()
    {
        $results = BivagKathamo::get();
        return view('post_office_kathamo', compact('results'));
    }
}
