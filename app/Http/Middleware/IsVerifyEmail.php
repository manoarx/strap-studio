<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use URL;

class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->is_email_verified) {
            
            $user = User::find(Auth::user()->id);

            $token = Str::random(64);
      
            UserVerify::create([
                  'user_id' => $user->id, 
                  'token' => $token
                ]);
            
            $verificationUrl = route('user.verify', $token);
            $userName = $user->username;
            $userType = $user->type;

            Mail::to($user->email)->send(new VerifyEmail($verificationUrl,$userName,$userType));

            auth()->logout();
            return redirect()->route('login')
                    ->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');
          }
   
        return $next($request);
    }
}