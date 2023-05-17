<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Riwayat;
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
        $data['total_proses_subkor'] = UserInformation::whereStatus(UserInformation::STATUS_SUBKOR)->count();
        $data['total_proses_kabid'] = UserInformation::whereStatus(UserInformation::STATUS_KABID)->count();
        $data['total_proses_kadis'] = UserInformation::whereStatus(UserInformation::STATUS_KADIS)->count();

        return view('administrator/home', compact('data'));
    }

    public function logout()
    {
        Auth::guard('administrator')->logout();
        Session::forget('user');
        return redirect()->route('administrator')->with('success', 'Logout Berhasil');
    }

    public function admin_profile(Request $request)
    {
        if (!empty($request->all())) {
            $data = $this->validate($request,[
                'name' => 'string',
                'username' => 'string',
                'phone' => 'string',
                'avatar' => 'file',
                'password' => 'sometimes|confirmed'
            ]);
            if(isset($data['avatar'])){
                $data['avatar'] = $request->file('avatar')->store('avatar');
            }
            if(isset($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }
            $administrator = Administrator::find(Auth::guard('administrator')->user()->id);
            $administrator->update(array_filter($data));
            return redirect()->back()->with('success', 'Berhasil update Profile');
        }
        return view('administrator.profile');
    }

}
