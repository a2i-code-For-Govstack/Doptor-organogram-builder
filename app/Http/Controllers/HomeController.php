<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\UserLoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        if ($this->checkProtikolpo()) {
            return redirect('protikolpo_revert');
        }
        if ($this->checkOfficeAdmin() == 'office_info') {
            return redirect('office_edit');
        }
        if ($this->checkOfficeAdmin() == 'unit_info') {
            return redirect('rename_office_unit');
        }
        if (!$this->isUserHasRole()) {
            return redirect('profile');
        }
        return view('dashboard');
    }

    public function officeInformation()
    {
        $userHasRole = \Auth::check() && $this->isUserHasRole();
        return view('office.information', compact('userHasRole'));
    }

    public function getOfficeInformation(Request $request)
    {
        if ($request->has('single_office_id') && bnToen($request->single_office_id) > 0) {
            $office_id = bnToen($request->single_office_id);
        } else {
            $office_id = $request->office_id;
        }
        $office_info = [];
        if ($office_id > 0) {
            $office_info = Office::where('id', $office_id)->first();
        }
        return view('office.get-office-info', compact('office_info'));
    }

    public function clearAlertNotification(Request $request)
    {
        session()->put(['alert_notifications' => 'hide']);
        return response()->json(['status' => 'success']);
    }

    public function officeWiseUserLogin(Request $request)
    {
        $userHasRole = \Auth::check() && $this->isUserHasRole();
        $first_login_time = UserLoginHistory::select('login_time')->first()->login_time;
        return view('user.login_history.office_wise_login_history', compact('userHasRole', 'first_login_time'));
    }

    public function getOfficeWiseUserLogin(Request $request)
    {
        $date_range = $request->date_range;

        $date_range = explode(' - ', $date_range);

        $start_date = $date_range[0];
        $end_date = $date_range[1];

        $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');

        $start_date = $start_date . ' 00:00:00';
        $end_date = $end_date . ' 23:59:59';

        $login_history_data = UserLoginHistory::getLoginHistoryDataOfficeWise([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $login_history = $login_history_data['login_history'];
        $first_login_time = $login_history_data['first_login_time'];
        $total_office_login = $login_history_data['total_office_login'];
        $total_unique_user_login_count = $login_history_data['total_unique_user_login_count'];

        $error_message = null;
        if (isset($login_history_data['error'])) {
            $error_message = $login_history_data['error'];
        }

        $data = [
            'login_history' => $login_history,
            'first_login_time' => $first_login_time,
            'total_office_login' => $total_office_login,
            'total_unique_user_login_count' => $total_unique_user_login_count,
            'error_message' => $error_message,
            'date_range' => $request->date_range,
        ];
        return view('user.login_history.get_office_wise_login_history', $data);
    }
}
