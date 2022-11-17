<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function index()
    {
        return view('login', [
            'title' => 'Login'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else if (auth()->user()->role == 'superadmin') {
                return redirect()->route('login')->with('success', 'Masuk super');
            } else if (auth()->user()->role == 'warehouse') {
                return redirect()->route('login')->with('success', 'Masuk ware');
            } else if (auth()->user()->role == 'purchasing') {
                return redirect()->route('login')->with('success', 'Masuk purch');
            } else {
                return redirect()->route('login')->with('success', 'Masuk TRM');
            }

        } else {
            return redirect()->route('login')->with('error', 'Username atau Password salah!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect('/');
    }
}
