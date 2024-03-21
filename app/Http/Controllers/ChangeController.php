<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class ChangeController
{
    public function changeDesignation($office_id, $office_unit_id, $designation_id): \Illuminate\Http\RedirectResponse
    {
        Session::put('_office_id', $office_id);
        Session::put('_office_unit_id', $office_unit_id);
        Session::put('_designation_id', $designation_id);
        return redirect()->route('dashboard');
    }

    public function changeLocale($locale): \Illuminate\Http\RedirectResponse
    {
        App::setLocale($locale);
        Session::put('locale', $locale);
        return redirect()->back();
    }
}
