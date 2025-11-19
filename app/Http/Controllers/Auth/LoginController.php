<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
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

    protected function redirectTo()
    {
        return '/welcome';
    }

    /**
     *  Este método se encarga de redirigir después del login
     *  pero forzamos que siempre use redirectTo(), ignorando intended()
     *  esto porque queremos que siempre vaya a /welcome
     *  y sobreescribimos el método del trait AuthenticatesUsers
     *  aunque esto no es lo ideal, es una solución rápida.
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        // 👇 Forzar que siempre se use redirectTo(), ignorando intended()
        return redirect($this->redirectPath());
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
