<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use App\Models\AdminAgenda;
use App\Models\ApplicantReference;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class   HomeController extends Controller
{
    public function index()
    {
        return view('agenda/agenda');
    }

    public function login(Request $request)
    {
        $user = AdminAgenda::whereUsername($request->username)->first();
        if($user){
            $check = Hash::check($request->password, $user->password);
            if($check){
                if(Auth::guard('agenda')->attempt(['username' => $request->username, 'password' => $request->password])){
                    Auth::guard('agenda')->login($user);
                    Session::put('user', $user);
                    return redirect()->route('dashboard-agenda')->with('success', 'Login Berhasil');
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
        Auth::guard('agenda')->logout();
        Session::forget('user');
        return redirect()->route('agenda')->with('success', 'Logout Berhasil');
    }

    public function home()
    {
        return view('agenda/home');
    }
    
    public function proses_berkas()
    {
        return view('agenda/agenda');
    }

    public function revisi()
    {
        return view('agenda/revisi');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('agenda/detail', compact('user_information'));
    }

    public function agenda_post(Request $request, $id)
    {
        $user_information = UserInformation::find($id);
        if(!$user_information->nomor_registration){
            $data = $this->validate($request, [
                'nomor_registration' => 'required|unique:user_informations',
                'nomor' => 'required'
            ]);
            $data['agenda_date'] = date('Y-m-d H:i:s');
        }
        $data['status'] = UserInformation::STATUS_SKETCH;
        $user_information->update($data);           
        $user_information->refresh();
        ApplicantReference::where('user_information_id', $id)->update([
            'status' => ApplicantReference::STATUS_APPROVE
        ]);
        if(!$user_information->nomor_registration){
            return redirect()->route('agenda-berkas-proses')->with('success', 'Berhasil buat Nomor Agenda');
        }else{
            return redirect()->route('agenda-berkas-proses')->with('success', 'Berhasil Revisi Agenda');
        }
    }

    public function reference(Request $request)
    {
        $data = $this->validate($request, [
            'user_information_id' => 'sometimes',
            'reference_type_id' => 'sometimes',
            'file' => 'required|mimes:pdf|max:20000'
        ]);
        $data['is_upload'] = 1;
        $data['file'] = $request->file('file')->store('file');
        if(!isset($data['user_information_id'])){
            $applicant_reference = ApplicantReference::find($request->id);
            Storage::delete($applicant_reference->file);
            $applicant_reference->update($data);
        }else{
            ApplicantReference::create($data);
        }
        return redirect()->back()->with('success', 'Data berhasil di simpan');
    }
    
    public function delete_reference(Request $request)
    {
        $id = $request->id;
        $applicant_reference = ApplicantReference::find($id);
        $applicant_reference->delete();
        return redirect()->back()->with('success', 'Data berhasil di hapus');
    }

    public function approve(Request $request)
    {
        $uuid = $request->id;
        UserInformation::where('uuid', $uuid)->update([
            'status' => UserInformation::STATUS_SKETCH,
        ]);
        return redirect()->route('agenda-revisi')->with('success', 'Berhasil');
    }
}
