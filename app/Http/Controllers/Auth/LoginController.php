<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/partner/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('partner.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $auth = false;
        $credentials = ['email' => $request->get('p_email'), 'password' => $request->get('p_password')];
        $intended = '/partner/home';
        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (! empty(Auth::user()) &&  Auth::user()->sponsor_type != 3) {
                $this->guard()->logout();

                $request->session()->invalidate();

                return redirect()->intended('/partner/login')->withErrors('Try login as a partner.');
            }
            if (Auth::user()->userstatus == 0) {
                $intended = 'partner/pending';
            } elseif (Auth::user()->is_suspend == 1) {
                $intended = 'partner/suspend';
            } else {
                $intended = $this->redirectPath();
            }
            $user = Auth::user();
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
            ]);
            $auth = true; // Success
        }

        return redirect()->intended($intended);

    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'p_email' => 'required|string',
            'p_password' => 'required|string',
        ]);
    }
}
