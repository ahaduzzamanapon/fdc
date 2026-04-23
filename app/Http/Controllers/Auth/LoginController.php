<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm($type = null)
    {
        if ($type) {
            session(['login_type' => $type]);
        }

        if (is_null($type)) {
            return view('font_end.body');
        }

        return view('auth.login', compact('type'));
    }

}
