<?php

namespace Ipsum\Admin\app\Http\Controllers\Auth;

use Ipsum\Admin\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Ipsum\Admin\app\Models\Admin;
use OTPHP\TOTP;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        login as authenticatesUsersLogin;
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('adminGuest')->except('logout');
    }


    public function showLoginForm()
    {
        return view('IpsumAdmin::auth.login');
    }

    public function login(Request $request)
    {
        session()->flash('remember', $request->boolean('remember'));
        return $this->authenticatesUsersLogin($request);
    }

    public function authenticated(Request $request, $admin)
    {
        session()->forget('admin_waiting_for_2af');
        if ($admin->secret_totp) {
            Auth::logout();
            session()->put('admin_waiting_for_2af', $admin->id);
            return redirect()->route('admin.login.2af');
        }
    }

    public function showLoginForm2AF()
    {
        if (!session()->has('admin_waiting_for_2af')) {
            return redirect()->route('admin.login');
        }
        return view('IpsumAdmin::auth.login_2af');
    }

    public function login2AF(Request $request, Admin $admin)
    {
        if (session()->get('admin_waiting_for_2af') != $admin->id) {
            return redirect()->route('admin.login');
        }

        $otp = TOTP::createFromSecret($admin->secret_totp);
        if ($otp->verify($request->secret_temp)) {

            Auth::login($admin, $request->remember);
            session()->forget('admin_waiting_for_2af');
            return redirect()->intended($this->redirectPath());
        }

        session()->flash('error', 'Code non valide');

        return back();
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }

    protected function redirectTo()
    {
        return '/'.config('ipsum.admin.route_prefix');
    }
}
