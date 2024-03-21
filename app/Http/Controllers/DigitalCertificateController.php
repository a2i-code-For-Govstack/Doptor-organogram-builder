<?php

namespace App\Http\Controllers;

use App\Models\DigitalCaList;
use App\Models\EmployeeRecord;
use App\Models\UserDigitalCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DigitalCertificateController
{
    public function getCertificate(Request $request)
    {
        try {
            $ca_id = $request->input('ca_id');
            $digital_ca = DigitalCaList::find($ca_id);
            if (!$digital_ca) {
                throw new \Exception('CA not found');
            }

            $user_id = auth()->user()->id;
            $employee_record_id = auth()->user()->employee_record_id;

            if ($digital_ca->short_name == 'bcc') {
                $employee_record = EmployeeRecord::where('id', $employee_record_id)->select('personal_mobile')->first();
                $signer_id = $employee_record->personal_mobile;

                if (!$signer_id) {
                    throw new \Exception('Mobile number not found.');
                }
                $signer_id = bnToen($signer_id);
                $signer_id = removeLeadingChars($signer_id, ['+', '8', '8']);

                $access_token_endpoint = $digital_ca->access_token_endpoint;
                $client_id = $digital_ca->client_id;
                $client_secret = $digital_ca->client_secret;

                $request_access_token = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->post($access_token_endpoint, [
                    'username' => $client_id,
                    'password' => $client_secret,
                ]);
                if ($request_access_token->status() != 200)
                    throw new \Exception('Access token request failed');

                $access_token = $request_access_token->json()['accessToken'];

                $get_certificate_endpoint = $digital_ca->get_certificate_endpoint;
                $request_get_certificate = Http::withToken($access_token)->post($get_certificate_endpoint, [
                    'userId' => $signer_id,
                ]);

                if ($request_get_certificate->status() == 400)
                    throw new \Exception('User ID is not correct.');
                if ($request_get_certificate->status() != 200)
                    throw new \Exception('Certificate not found.');


                if ($request_get_certificate->status() != 200 || !isset($request_get_certificate->json()['data']['key_alias']))
                    throw new \Exception('Certificate not found.');

                UserDigitalCertificate::where('user_id', $user_id)->where('digital_ca_id', $ca_id)->update([
                    'status' => 0,
                ]);

                $request_get_certificate = $request_get_certificate->json();
                $user_digital_certificate = new UserDigitalCertificate();
                $user_digital_certificate->user_id = $user_id;
                $user_digital_certificate->employee_record_id = $employee_record_id;
                $user_digital_certificate->signer_id = $signer_id;
                $user_digital_certificate->digital_ca_id = $ca_id;
                $user_digital_certificate->certificate = $request_get_certificate['data']['key_alias'];
                $user_digital_certificate->base64_certificate = $request_get_certificate['data']['certificate'];
                $user_digital_certificate->status = 1;
                $user_digital_certificate->save();
            } else if ($digital_ca->short_name == 'mangoca') {
                $signer_id = auth()->user()->employee->nid;
                if (!$signer_id) {
                    throw new \Exception('National Identity Card number not found.');
                }
                $signer_id = bnToen($signer_id);
                $callback_url = url('get-web-certificate');

                $get_certificate_payload = base64_encode(
                    json_encode([
                        'ba_return_url' => $callback_url,
                        'signerId' => $signer_id,
                    ]),
                );
                session()->put('ca_id', $ca_id);
                session()->put('ca', 'mangoca');
                $get_certificate_url = $digital_ca->get_certificate_endpoint . '/request-for-certificate?data=' . $get_certificate_payload;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Digital certificate is generated.',
                    'url' => $get_certificate_url,
                    'type' => 'redirect',
                ]);
            } else {
                throw new \Exception('This certificate is not supported.');
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Digital certificate is generated.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Digital certificate could not be generated.',
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function getWebCertificate(Request $request)
    {
        if (session('ca') == 'mangoca') {
            if ($request->has('data') && !empty($request->data)) {
                $data = json_decode(base64_decode($request->data), true);
                $user_certificate = UserDigitalCertificate::updateOrCreate([
                    'user_id' => auth()->id(),
                    'employee_record_id' => auth()->user()->employee_record_id,
                    'signer_id' => $data['signerId'],
                    'digital_ca_id' => session('ca_id'),
                    'certificate' => $data['app_token'],
                    'status' => 1,
                ], ['user_id' => auth()->id()]);
            }
        }
        session()->forget('ca');
        session()->forget('ca_id');
        return redirect('profile');
    }
}
