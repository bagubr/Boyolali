<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function login(Request $request)
    {
        $user = Administrator::whereUsername($request->username)->first();
        if($user){
            $check = Hash::check($request->password, $user->password);
            if($check){
                if(Auth::guard('administrator')->attempt(['username' => $request->username, 'password' => $request->password])){
                    Auth::guard('administrator')->login($user);
                    Session::put('user', $user);
                    return redirect()->route('administrator-dashboard')->with('success', 'Login Berhasil');
                }else{
                    return redirect()->back()->with('error', 'Password yang anda masukan salah');
                }
            }else{
                return redirect()->back()->with('error', 'Password yang anda masukan salah');
            }
        }else{
            return redirect()->back()->with('error', 'Username yang anda masukan tidak terdaftar');
        }
    }

    public function home()
    {
        return view('administrator/home');
    }

    public function logout()
    {
        Auth::guard('administrator')->logout();
        Session::forget('user');
        return redirect()->route('administrator')->with('success', 'Logout Berhasil');
    }
}
