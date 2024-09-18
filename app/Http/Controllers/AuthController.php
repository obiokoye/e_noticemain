<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        if(!empty(Auth::check()))
        {
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = !empty($request->remember) ? true : false;

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember))
        {
           return redirect('dashboard')->with('success', 'Successfully login');
        }
        else{
            return redirect()->back()->with('error', "Please enter Valid email and password");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
