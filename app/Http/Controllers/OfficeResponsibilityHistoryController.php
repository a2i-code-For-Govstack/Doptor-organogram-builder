<?php

namespace App\Http\Controllers;

use App\Models\AdminResponsibilityLog;
use Illuminate\Http\Request;

class OfficeResponsibilityHistoryController extends Controller
{
    public function officeAdminResponsibilityLog()
    {

        return view('office_responsibility_history.office_admin_log');
    }

    public function officeAdminResponsibilityLogList(Request $request)
    {
        $responsible_log_list = AdminResponsibilityLog::where('office_id', $request->office_id)->where('admin_type', 'office_admin')->orderBy('assign_to', 'DESC')->get();
        $current_responsible = $responsible_log_list->whereNull('assign_to')->first();
        $responsible_log_list = $responsible_log_list->sortByDesc('assign_to')->whereNotNull('assign_to');
        return view('office_responsibility_history.responsibility_log_list', compact('responsible_log_list', 'current_responsible'));
    }

    public function officeHeadResponsibilityLog()
    {

        return view('office_responsibility_history.office_head_log');
    }

    public function officeHeadResponsibilityLogList(Request $request)
    {
        $responsible_log_list = AdminResponsibilityLog::where('office_id', $request->office_id)->where('admin_type', 'office_head')->orderBy('assign_to', 'DESC')->get();
        $current_responsible = $responsible_log_list->whereNull('assign_to')->first();
        $responsible_log_list = $responsible_log_list->sortByDesc('assign_to')->whereNotNull('assign_to');

        return view('office_responsibility_history.responsibility_log_list', compact('responsible_log_list', 'current_responsible'));
    }

    public function officeUnitAdminResponsibilityLog()
    {

        return view('office_responsibility_history.unit_admin_log');
    }

    public function officeUnitAdminResponsibilityLogList(Request $request)
    {
        $responsible_log_list = AdminResponsibilityLog::where('office_id', $request->office_id)->where('admin_type', 'office_unit_admin')->orderBy('assign_to', 'DESC')->get();
        $current_responsible = $responsible_log_list->whereNull('assign_to')->first();
        $responsible_log_list = $responsible_log_list->sortByDesc('assign_to')->whereNotNull('assign_to');

        return view('office_responsibility_history.responsibility_log_list', compact('responsible_log_list', 'current_responsible'));
    }
}
