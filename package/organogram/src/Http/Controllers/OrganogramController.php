<?php

namespace a2i\organogram\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
// use ut\contacts\Models\contact;

class OrganogramController extends Controller
{
    public function index():View{
        return view('organogrampkg::test');
    }
    public function send(Request $request){
    // Mail::to('utkarshsrivastava434@gmail.com')->send(new OrderShipped($request->message));
    // contact::create($request->all());
    return redirect('contacts');
    // return $request->all();

    }
}
