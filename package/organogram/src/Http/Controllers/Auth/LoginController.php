<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use a2i\organogram\database\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectAfterLogout = '/login';
    protected $redirectTo = '/dashboard';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(): string
    {
        return 'username';
    }

    public function login(Request $request)
    {
        session()->invalidate();
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();

        if (!$user) {
            return back()->withErrors(['message1' => 'User Not Found']);
        }

        if ($user->force_password_change == 1) {
            return redirect(route('password.request'));
        }

        if (\Hash::check($password, $user->password)) {
            Auth::login($user);
            return redirect('dashboard');
        } else {
            return back();
        }

    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }
}
