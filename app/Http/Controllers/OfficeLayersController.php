<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeLayersController extends Controller
{

    public function index()
    {
        return view('office.layers');
    }
}
