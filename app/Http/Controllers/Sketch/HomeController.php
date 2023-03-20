<?php

namespace App\Http\Controllers\Sketch;

use App\Http\Controllers\Controller;
use App\Models\AdminSketch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function login(Request $request)
    {
        $user = AdminSketch::whereUsername($request->username)->first();
        if($user){
            $check = Hash::check($request->password, $user->password);
            if($check){
                if(Auth::guard('sketch')->attempt(['username' => $request->username, 'password' => $request->password])){
                    Auth::guard('sketch')->login($user);
                    Session::put('user', $user);
                    return redirect()->route('dashboard-sketch')->with('success', 'Login Berhasil');
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
}
