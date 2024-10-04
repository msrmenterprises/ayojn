<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/bid';
    public $redirectTo1 = '/opportunity';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */

    public function redirectTo()
    {
        if (Auth::check() && Auth::user()->sponsor_type == 1) {
            return session('url.intended') ?? $this->redirectTo1;
        } else {
            return session('url.intended') ?? $this->redirectTo;
        }

    }

    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $auth = false;
        $credentials = $request->only('email', 'password');
        $intended = '/';
        if (Auth::attempt($credentials, $request->has('remember'))) {

            if (strtotime(Auth::user()->disapprove_time) <= strtotime(Carbon::now()->toDateTimeString())) {
                $intended = '/pending';
            } elseif (Auth::user()->userstatus == 0) {
                $intended = '/pending';
            } elseif (Auth::user()->is_suspend == 1) {
                $intended = '/suspend';
            } else {
                $intended = $this->redirectTo();
            }
            $user = Auth::user();

            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
            ]);
            $auth = true; // Success
        }

        if ($request->ajax()) {
            if (! empty(Auth::user()) &&  Auth::user()->sponsor_type == 3) {
                $this->guard()->logout();

                $request->session()->invalidate();

                return response()->json([
                    'status' => 2,
                    'auth' => $auth,
                    'intended' => $intended
                ]);
            }
            if (! empty(Auth::user()) && Auth::user()->email_verified == 0) {
                $this->guard()->logout();

                $request->session()->invalidate();

                return response()->json([
                    'status' => 0,
                    'auth' => $auth,
                    'intended' => '/'
                ]);
            } else {
                return response()->json([
                    'status' => 1,
                    'auth' => $auth,
                    'intended' => $intended
                ]);
            }

        } else {
            return redirect()->intended($this->redirectPath());
        }

        return redirect(URL::route('/'));
    }

    /*public function login(Request $request)
    {

        $this->validateLogin($request);

        //dd($validation);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }*/


    protected function validateLogin(Request $request)
    {
        /*$this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);*/

        $this->validate($request, [
            $this->username() => [
                'required',
                'string'
            ],
            'password' => 'required|string',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('user')->logout();
        session()->flush();

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return $this->loggedOut($request) ? : redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }
}
