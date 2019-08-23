<?php

namespace Ipsum\Admin\app\Http\Controllers\Auth;

use Ipsum\Admin\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('adminGuest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('IpsumAdmin::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function showLinkRequestForm()
    {
        return view('IpsumAdmin::auth.passwords.email');
    }

    protected function redirectTo()
    {
        return '/'.config('ipsum.admin.route_prefix');
    }

    public function broker()
    {
        return Password::broker('ipsumAdmin');
    }

    protected function guard()
    {
        return Auth::guard(config('ipsum.admin.guard'));
    }
}
