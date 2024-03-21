<?php

namespace App\Http\Controllers;

use App\Models\BivagKathamo;

class PouroshovaWordKathamoController extends Controller
{
    public function index()
    {
        $results = BivagKathamo::get();

        return view('pourosoba_word_kathamo', compact('results'));
    }
}
