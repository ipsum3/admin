<?php

namespace Ipsum\Admin\app\Http\Controllers\Auth;

use Ipsum\Admin\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;


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

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }

    protected function redirectTo()
    {
        return '/'.config('ipsum.admin.route_prefix');
    }
}
