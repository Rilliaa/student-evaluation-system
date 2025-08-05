<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Redirect default untuk admin

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
     * Override the login method to handle role-based authentication and redirect.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validasi input form
        $request->validate([
            'role' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $role = $request->input('role');
        $username = $request->input('username');
        $password = $request->input('password');

        // untuk menentukan model dan kolom yang digunakan sebagai username dan password
        switch ($role) {
            case 'admin':
                $model = \App\Models\User::class;
                $column = 'email';
                $dashboard = '/home'; // redirect ke dashboard admin
                $guard = 'web'; // guard untuk admin
                break;
            case 'guru':
                $model = \App\Models\Guru::class;
                $column = 'nip';
                $dashboard = route('dashboard.guru'); 
                $guard = 'guru'; 
                break;
            case 'murid':
                $model = \App\Models\Murid::class;
                $column = 'nisn';
                $dashboard = route('dashboard.murid'); 
                $guard = 'murid'; 
                break;
            case 'wali':
                $model = \App\Models\Ortu::class;
                $column = 'username';
                $dashboard = route('dashboard.ortu'); 
                $guard = 'wali'; 
                break;
            default:
                return back()->withErrors(['role' => 'Role tidak valid']);
        }
        
        // cek apakah user beneran ada atau tidak
        $user = $model::where($column, $username)->first();
        
        // verif
        if ($user && Hash::check($password, $user->password)) {
            Auth::guard($guard)->login($user);
            return redirect()->intended($dashboard);
        }
        
        // kalau autentikasi gagal
        return back()->withErrors([
            'username' => ucfirst($column) . ' atau password salah.',
        ]);
    }
}        