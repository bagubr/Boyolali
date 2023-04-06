<?php

namespace App\Http\Controllers\Sketch;

use App\Http\Controllers\Controller;
use App\Models\AdminSketch;
use App\Models\Gsb;
use App\Models\Krk;
use App\Models\SketchFile;
use App\Models\UserInformation;
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

    public function home()
    {
        return view('sketch/home');
    }

    public function proses_berkas()
    {
        return view('sketch/sketch');
    }

    public function revisi()
    {
        return view('sketch/revisi');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('admin_templates/detail', compact('user_information'));
    }

    public function logout()
    {
        Auth::guard('sketch')->logout();
        Session::forget('user');
        return redirect()->route('sketch')->with('success', 'Logout Berhasil');
    }

    public function upload(Request $request)
    {
        $data = $this->validate($request, [
            'file' => 'required',
            'user_information_id' => 'required|exists:user_informations,id',
        ]);
        $data['file'] = $request->file('file')->store('sketchs');
        SketchFile::updateOrCreate([
            'user_information_id' => $data['user_information_id']
        ],$data);
        return redirect()->back()->with('success', 'Data berhasil di simpan');
    }

    public function sketch_post(Request $request)
    {
        $data = $this->validate($request, [
            'uuid' => 'string|required',
            'kbg' => 'sometimes|nullable|string',
            'kdb' => 'sometimes|nullable|string',
            'klb' => 'sometimes|nullable|string',
            'kdh' => 'sometimes|nullable|string',
            'psu' => 'sometimes|nullable|string',
            'jaringan_utilitas' => 'sometimes|nullable|string',
            'prasarana_jalan' => 'sometimes|nullable|string',
            'sungai_bertanggul' => 'sometimes|nullable|string',
            'sungai_tidak_bertanggul' => 'sometimes|nullable|string',
            'mata_air' => 'sometimes|nullable|string',
            'waduk' => 'sometimes|nullable|string',
            'tol' => 'sometimes|nullable|string',
            'ktb' => 'sometimes|nullable|string',
            'building_function' => 'string|required',
            'zona' => 'string|required',
        ]);
        Krk::updateOrCreate([
            'uuid' => $data['uuid']
        ],$data);

        $data = $this->validate($request, [
            'jap' => 'sometimes|nullable|string',
            'jkp' => 'sometimes|nullable|string',
            'jks' => 'sometimes|nullable|string',
            'jlp' => 'sometimes|nullable|string',
            'jls' => 'sometimes|nullable|string',
            'jling' => 'sometimes|nullable|string',
            'uuid' => 'string|required',
        ]);
        Gsb::updateOrCreate([
            'uuid' => $data['uuid']
        ],$data);
        return redirect()->back()->with('success', 'Data berhasil di simpan');
    }
}
