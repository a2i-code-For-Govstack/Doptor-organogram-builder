<?php

namespace App\Http\Controllers;

use App\Models\ApiClient;
use App\Models\ApplicationRegistration;
use App\Traits\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ApplicationRegistrationController extends Controller
{
    use SendNotification;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('applicationregistration.approved_applications');
    }

    public function approvedApplicationsList()
    {
        $approved_applications = ApiClient::whereStatus(1)->with('application')->get();
        return view('applicationregistration.approved_applications_list', compact('approved_applications'));
    }

    public function suspended()
    {
        return view('applicationregistration.suspended_applications');
    }

    public function suspendedApplicationsList()
    {
        $suspended_applications = ApiClient::whereStatus(0)->with('application')->get();
        return view('applicationregistration.suspended_applications_list', compact('suspended_applications'));
    }

    public function pendingApplications()
    {
        return view('applicationregistration.pending_applications');
    }

    public function pendingApplicationList()
    {
        $pending_applications = ApplicationRegistration::where('is_approved', 0)->where('is_rejected', 0)->get();
        return view('applicationregistration.pending_applications_list', compact('pending_applications'));
    }

    public function approveApplication($application_id)
    {
        DB::beginTransaction();
        try {
            $pending_application = ApplicationRegistration::find($application_id);

            $client_id = generateRandomString(6);
            $password = generateRandomString(8);

            $api_client = new ApiClient();
            $api_client->name = $pending_application->application_name_en;
            $api_client->application_registration_id = $pending_application->id;
            $api_client->client_id = $client_id;
            $api_client->password = bcrypt($password);
            $api_client->status = 1;

            $pending_application->status = 1;
            $pending_application->is_approved = 1;

            $api_client->save();
            $pending_application->save();

            $this->sendMailNotification(
                config('notifiable_constants.application_registered'),
                $pending_application->email_address,
                'Application is approved.',
                [
                    'name_en' => $pending_application->application_name_en,
                    'name_bn' => $pending_application->application_name_bn,
                    'client_id' => $client_id,
                    'password' => $password
                ]
            );
            $this->sendSMSNotification(config('notifiable_constants.application_registered'), $pending_application->mobile_number, $pending_application->application_name_bn);

            DB::commit();
            return response(['status' => 'success', 'msg' => 'Approval has been given.', 'data' => ['client_id' => $client_id, 'password' => $password]]);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => 'Approval was not possible.', 'data' => $e]);
        }
    }

    public function addApplication()
    {
        return view('applicationregistration.add_application');
    }

    public function editPendingApplication(Request $request, $id)
    {
        $application = ApiClient::findOrFail($id);
        return view('applicationregistration.edit_pending_application', compact('application'));
    }

    public function store(Request $request)
    {
        if (ApplicationRegistration::create($request->all()))
            return redirect('application_registration_pending')->with('success', "Application has been registered. Approve registration.");
        else
            return back()->with('error', "Application registration failed.");

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $pending_application = ApplicationRegistration::findOrFail($request->id);
        $pending_application->application_name_en = $request->application_name_en;
        $pending_application->application_name_bn = $request->application_name_bn;
        $pending_application->url = $request->url;
        $pending_application->redirect_url = $request->redirect_url;
        $pending_application->default_page_url = $request->default_page_url;
        $pending_application->logout_url = $request->logout_url;
        $pending_application->mobile_number = $request->mobile_number;
        $pending_application->email_address = $request->email_address;
        $pending_application->slo_url = $request->slo_url;
        $pending_application->logo_url = $request->logo_url;
        $pending_application->status = $request->status;
        $pending_application->is_widget_show = $request->is_widget_show;
        $pending_application->sync_api_url = $request->sync_api_url;
        if ($pending_application->save()) {
            return response(['status' => 'success', 'msg' => 'Editing done.']);
        } else
            return response(['status' => 'error', 'msg' => 'Editing was not possible.']);
    }

    public function suspendApplication($application_id)
    {
        DB::beginTransaction();
        try {
            $api_client = ApiClient::find($application_id);
            if ($api_client) {
                $api_client->status = 0;
                $api_client->save();
            }

            $application = ApplicationRegistration::find($api_client->application_registration_id);
            if ($application) {
                $application->status = 0;
                $application->save();
            }
            DB::commit();
            return response(['status' => 'success', 'msg' => 'Authorization has been suspended.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => 'Unable to suspend approval.', 'data' => $e]);
        }
    }

    public function reAllowApplication($application_id, $old = '')
    {
        DB::beginTransaction();
        try {
            $api_client = ApiClient::find($application_id);
            if ($old != 'old') {
                $application = ApplicationRegistration::find($api_client->application_registration_id);
                $application->status = 1;
                $application->save();
            }
            $api_client->status = 1;
            $api_client->save();
            DB::commit();
            return response(['status' => 'success', 'msg' => 'Reauthorized']);
        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 'error', 'msg' => 'Unable to reauthorize.', 'data' => $e]);
        }
    }

    public function generateApprovedApplicationExcelFile(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $approved_applications = ApiClient::whereStatus(1)->with('application')->get();

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'Registered list');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Application name');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('B2', 'Application Name (Bangla)');
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C2', 'Url');
        $sheet->getStyle('C2')->getFont()->setBold(true);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('D2', 'Mobile');
        $sheet->getStyle('D2')->getFont()->setBold(true);
        $sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E2', 'Email');
        $sheet->getStyle('E2')->getFont()->setBold(true);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F2', 'Date of approval');
        $sheet->getStyle('F2')->getFont()->setBold(true);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $count = 3;
        foreach ($approved_applications as $approved_application) {
            if($approved_application->application) {
                // dd($approved_application->application);
                $sheet->setCellValue('A' . $count, $approved_application->application->application_name_en);
                $sheet->getStyle('A' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('B' . $count, $approved_application->application->application_name_bn);
                $sheet->getStyle('B' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('C' . $count, $approved_application->application->url);
                $sheet->getStyle('C' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('D' . $count, $approved_application->application->mobile_number);
                $sheet->getStyle('D' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('E' . $count, $approved_application->application->email_address);
                $sheet->getStyle('E' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->setCellValue('F' . $count, $approved_application->application->created);
                $sheet->getStyle('F' . $count)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $count++;
            }
        }

        // Dynamically spread every column.
        expand_spreadsheet($sheet, $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/Registered list.xlsx');
        $file_name = 'Registered list.xlsx';
        $full_path = url('storage/Registered list.xlsx');
        return json_encode(['file_name' => $file_name, 'full_path' => $full_path]);
    }
}
