<?php

namespace App\Http\Controllers\Survei;

use App\Http\Controllers\Controller;
use App\Models\AdminSurvei;
use App\Models\InterrogationReport;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    
    public function login(Request $request)
    {
        $user = AdminSurvei::whereUsername($request->username)->first();
        if($user){
            $check = Hash::check($request->password, $user->password);
            if($check){
                if(Auth::guard('survei')->attempt(['username' => $request->username, 'password' => $request->password])){
                    Auth::guard('survei')->login($user);
                    Session::put('user', $user);
                    return redirect()->route('dashboard-survei')->with('success', 'Login Berhasil');
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

    public function logout()
    {
        Auth::guard('survei')->logout();
        Session::forget('user');
        return redirect()->route('survei')->with('success', 'Logout Berhasil');
    }

    public function home()
    {
        return view('survei/home');
    }

    public function proses_berkas()
    {
        return view('survei/survei');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('survei/detail', compact('user_information'));
    }
    
    public function survei_interrogation_report(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('interrogation_report');
    }
    
    public function survei_bap(Request $request)
    {
        $data = $this->validate($request, [
            'user_information_id'   => 'required',
            'building_condition'    => 'required',
            'street_name'           => 'required',
            'allocation'            => 'required',
            'note'                  => 'required',
            'employee'              => 'required',
        ]);
        $data['employee'] = json_encode($data['employee']);
        $interrogation_report = InterrogationReport::updateOrCreate(['user_information_id' => $data['user_information_id']], $data);
        // if($interrogation_report->wasRecentlyCreated){
        //     UserInformation::where('id', $data['user_information_id'])->update([
        //         'status' => UserInformation::STATUS_SKETCH,
        //         'survei_date' => date('Y-m-d H:i:s'),
        //     ]);
        // }
        return redirect()->back()->with('success', 'Data berhasil di tambahkan');
    }
    
    public function delete_bap(Request $request)
    {
        $uuid = $request->id;
        $user_information = UserInformation::where('uuid', $uuid)->first();
        $user_information->interrogation_report->delete();
        return redirect()->back()->with('success', 'Data berhasil di hapus');
    }
    
    public function approve(Request $request)
    {
        $uuid = $request->id;
        UserInformation::where('uuid', $uuid)->update([
            'status' => UserInformation::STATUS_SKETCH,
            'survei_date' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('survei-berkas-proses')->with('success', 'Berhasil');
    }

    public function revisi()
    {
        return view('survei/revisi');
    }
}
