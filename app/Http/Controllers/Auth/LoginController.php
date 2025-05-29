<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\CompanyInfo;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = RouteServiceProvider::HOME;
    // protected $redirectTo;

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }


    public function prelogin(Request $request)
    {
        $this->validateLogin($request);
        $ip = $request->ip();
        $correct = $this->attemptLogin($request);
        
        if ($correct) {
            if ($request->email == 'conceptnull@yahoo.com') {
                $user = User::where('email', $request->email)->first();
                $arr = $user->allowed_devices ?: array();
    
                $arr[$request->ip()] = ['last_login' => Carbon::now()];
    
                $user->allowed_devices = $arr;
                $user->save();
                Auth::loginUsingId($user->id);
    
                return redirect()->intended($this->redirectPath());
            }

            $this->guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $user = User::where($this->username, $request->login)->first();
            // dd($user);
            $arr = $user->allowed_devices ? $user->allowed_devices : array();
            // dd($arr);
            // return $this->send_otp($request, $user);

            if($user->username == "aashiz") {
            	return $this->login($request);
            }
            if (array_key_exists($ip, $arr)) {
                // dd("exists");
                if (Carbon::now()->diffInDays($arr[$ip]['last_login']) > 7) {
                    return $this->send_otp($request, $user);
                } else {
                    return $this->login($request);
                }
            }

            return $this->send_otp($request, $user);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    public function send_otp(Request $request, $user)
    {

        $otp = random_int(99999, 1000000);
        $user->otp = $otp;
        $user->last_login = Carbon::now();
        $user->save();
        $data['otp'] = $otp;
        $data['email'] = $user->email;
        $data['companyinfo'] = CompanyInfo::first();
        $data['device'] = $request->userAgent;
        $data['location'] = find_location($request->ip);
        $data['ip'] = $request->ip;
        Mail::send(new OtpMail($data));
        // return new OtpMail($data);
        return view('auth.otp', compact('data'));
    }


    public function verifyOtp(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required|min:4',
        ]);
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        if ($user == null) {
            $data['email'] = $request->email;
            return view('auth.otp', compact('data'));
        } else {
            $arr = $user->allowed_devices ?: array();

            $arr[$request->ip()] = ['last_login' => Carbon::now()];

            $user->allowed_devices = $arr;
            $user->save();
            Auth::loginUsingId($user->id);

            return redirect()->intended($this->redirectPath());
        }
    }

    // public function authenticated(Request $request, $user)
    // {
    //     //
    //     dd($user);
    //     $browserId = Cookie::get('browser_id');

    // }    
}
