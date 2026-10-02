<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    protected function authenticated(Request $request, $user)
    {
        DB::table('users')->where('id', $user->id)->update([
            'logins' => DB::raw('COALESCE(logins, 0) + 1'),
            'last_login' => now(),
            'updated_at' => now(),
        ]);

        // If user must change password, redirect to forced change page
        if ($user->password_change == 1) {
            return redirect()->route('force.password.change');
        }
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::where($this->username(), $request->input($this->username()))->first();

        // Expired security reset codes must not continue to authenticate.
        if (
            $user
            && $user->password_change == 1
            && $user->password_reset_otp
            && $user->password_reset_otp_expires_at
            && $user->password_reset_otp_expires_at->isPast()
        ) {
            return false;
        }

        return $this->guard()->attempt(
            $this->credentials($request),
            $request->boolean('remember')
        );
    }

}
