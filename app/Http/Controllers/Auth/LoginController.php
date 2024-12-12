<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Models\User;
use App\Models\UserVerify;
use Hash;
use Illuminate\Support\Str;
use Mail;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    // 1 - Admin, 2 - Customer, 0 - School Users
    public function login(Request $request)
    {
        $input = $request->all();
     
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            // The user provided an email address
            $credentials = ['email' => $input['email'], 'password' => $input['password']];
        } else {
            // The user provided a username
           $credentials = ['username' => $input['email'], 'password' => $input['password']];
        }
     
        if (auth()->attempt($credentials))
        {

            if (auth()->user()->hasVerifiedEmail()) {
                // 1 - Admin, 2 - Customer, 0 - School Users
                if (auth()->user()->type == 'admin') {
                    return redirect()->route('admin.schools.index');
                } else if (auth()->user()->type == 'customer') {
                    return redirect()->route('customer.profile');
                } else {
                    return redirect()->route('school.home');
                }

            } else {
                return redirect()->route('verifyemail')->with('error','Please verify your email.');

            }

        } else {

            return redirect()->route('login')->with('error','Username And Password Are Wrong.');

        }
          
    }

    public function logout()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('login');
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->email_verified_at = now();
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
  
      return redirect()->route('login')->with('message', $message);
    }
}
