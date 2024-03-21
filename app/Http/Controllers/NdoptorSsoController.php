<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NdoptorSsoController extends Controller
{
    public function initDoptorSSOToken(Request $request)
    {

        if (isset($_COOKIE['ntoken'])) {
            return;
        }

        $username = $request->username;
        $access_token = $request->access_token;

        $ntoken = [
            'username' => $username,
            'access_token' => $access_token
        ];

        $ntoken = encrypt($ntoken);
        setcookie('ntoken', $ntoken, time() + 3600, '/');
        return response()->json(['action' => 'reload']);
    }

    public function destroyDoptorSSOToken(Request $request)
    {
        if (isset($_COOKIE['ntoken'])) {
            unset($_COOKIE['ntoken']);
            setcookie('ntoken', null, -1, '/');
            return response()->json(['action' => 'reload']);
        } else {
            return;
        }
    }

    public function logout(Request $request)
    {
        if (isset($_COOKIE['ntoken'])) {
            unset($_COOKIE['ntoken']);
            setcookie('ntoken', null, -1, '/');
            $logout_url = config('ndoptor_sso.sso_base_url') . 'auth/realms/' . config('ndoptor_sso.sso_realm') . '/protocol/openid-connect/logout?redirect_uri=' . config('ndoptor_sso.sso_client_url');
            return redirect($logout_url);
        }
    }

    public function redirectionHandler(Request $request)
    {
        $forward_url = $request->forward_url;
        if (!$forward_url) {
            $forward_url = url('/');
        } else {
            $forward_url = url(urldecode($forward_url));
        }

        if (isset($_COOKIE['ntoken'])) {
            return redirect($forward_url);
        }
        return view('sso_redirector');
    }
}
