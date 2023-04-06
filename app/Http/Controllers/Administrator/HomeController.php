<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\UserInformation;
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
        $data['total_proses_berkas'] = UserInformation::whereStatus(UserInformation::STATUS_FILING)->count();
        $data['total_proses_selesai'] = UserInformation::whereStatus(UserInformation::STATUS_CEK)->count();
        $data['total_proses_validasi'] = UserInformation::whereIn('status', UserInformation::STATUS_VALIDASI)->count();
        $data['total_berkas_selesai'] = UserInformation::whereStatus(UserInformation::STATUS_SELESAI)->count();
        return view('administrator/home', compact('data'));
    }

    public function logout()
    {
        Auth::guard('administrator')->logout();
        Session::forget('user');
        return redirect()->route('administrator')->with('success', 'Logout Berhasil');
    }

    public function approve(Request $request)
    {
            $uuid = $request->id;
        if (Auth::guard('administrator')->user()->role == 'FILING') {
            $status = \App\Models\UserInformation::STATUS_SUBKOR;
        }elseif (Auth::guard('administrator')->user()->role == 'CEK') {
            $status = \App\Models\UserInformation::STATUS_SUBKOR;
        }elseif (Auth::guard('administrator')->user()->role == 'SUBKOR') {
            $status = \App\Models\UserInformation::STATUS_SUBKOR;
        }elseif (Auth::guard('administrator')->user()->role == 'KABID') {
            $status = \App\Models\UserInformation::STATUS_KADIS;
        }elseif (Auth::guard('administrator')->user()->role == 'KADIS') {
            $status = \App\Models\UserInformation::STATUS_CETAK;
        }elseif (Auth::guard('administrator')->user()->role == 'CETAK') {
            $status = \App\Models\UserInformation::STATUS_SELESAI;
        }else {
            $status = \App\Models\UserInformation::STATUS_FILING;
        }
        
        UserInformation::where('uuid', $uuid)->update([
            'status' => $status,
            'agenda_date' => date('Y-m-d H:i:s'),
        ]);

        if (Auth::guard('administrator')->user()->role == 'FILING') {
            return redirect()->route('agenda-berkas-proses')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'CEK') {
            return redirect()->route('agenda-berkas-proses')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'KABID') {
            return redirect()->route('kabid-berkas-proses')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'KADIS') {
            return redirect()->route('kadis-berkas-proses')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'CETAK') {
            return redirect()->route('cetak-berkas-proses')->with('success', 'Berhasil');
        }else {
            return redirect()->back()->with('success', 'Berhasil');
        }
        return redirect()->back()->with('success', 'Berhasil');
    }
    
    public function save(Request $request)
    {
        $uuid = $request->id;
        
        UserInformation::where('uuid', $uuid)->update([
            'status' => 'CEK',
        ]);
        
        return redirect()->route('agenda-berkas-proses')->with('success', 'Berhasil');
    }

    public function revision(Request $request)
    {
        $uuid = $request->id;
        if (Auth::guard('administrator')->user()->role == 'FILING') {
            $status = \App\Models\UserInformation::STATUS_CEK;
        }elseif (Auth::guard('administrator')->user()->role == 'CEK') {
            $status = \App\Models\UserInformation::STATUS_KABID;
        }elseif (Auth::guard('administrator')->user()->role == 'KABID') {
            $status = \App\Models\UserInformation::STATUS_KADIS;
        }elseif (Auth::guard('administrator')->user()->role == 'KADIS') {
            $status = \App\Models\UserInformation::STATUS_CETAK;
        }elseif (Auth::guard('administrator')->user()->role == 'CETAK') {
            $status = \App\Models\UserInformation::STATUS_SELESAI;
        }else {
            $status = \App\Models\UserInformation::STATUS_FILING;
        }
        UserInformation::where('uuid', $uuid)->update([
            'status' => $status
        ]);
        if (Auth::guard('administrator')->user()->role == 'FILING') {
            return redirect()->route('agenda-revisi')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'CEK') {
            return redirect()->route('sketch-revisi')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'KABID') {
            return redirect()->route('kabid-revisi')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'KADIS') {
            return redirect()->route('kadis-revisi')->with('success', 'Berhasil');
        }elseif (Auth::guard('administrator')->user()->role == 'CETAK') {
            return redirect()->route('cetak-revisi')->with('success', 'Berhasil');
        }else {
            return redirect()->back()->with('success', 'Berhasil');
        }
    }
}
