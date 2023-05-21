<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use App\Models\AdminAgenda;
use App\Models\ApplicantReference;
use App\Models\Polygon;
use App\Models\Riwayat;
use App\Models\UserInformation;
use App\Notifications\AgendaCreate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

    public function selesai()
    {
        return view('agenda/selesai');
    }
    
    public function berkas_selesai()
    {
        return view('agenda/berkas-selesai');
    }

    public function berkas_selesai_post(Request $request)
    {
        $data = $this->validate($request, [
            'uuid' => 'required',
            'to' => 'required',
            'note' => 'required',
        ],[
            'to' => 'Belum pilih proses selanjutnya',
            'note' => 'Catatan blm di isi',
        ]);
        $user_information = UserInformation::where('uuid', $data['uuid'])->first();
        if(!$user_information->nomor_krk){
            return redirect()->back()->with('error', 'Nomor SK blm di isi');
        }
        $data['user_information_id'] = $user_information->id;
        $data['from'] = Auth::guard('administrator')->user()->role;
        $data['from_id'] = Auth::guard('administrator')->user()->id;
        Riwayat::create($data);
        $data_information['agenda_date'] = date('Y-m-d H:i:s');
        $data_information['status'] = $data['to'];
        $user_information->update($data_information);
        return redirect()->route('agenda-berkas-selesai')->with('success', 'Berhasil');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('admin_templates/detail', compact('user_information'));
    }

    public function agenda_post(Request $request, $id)
    {
        $user_information = UserInformation::find($id);
        if(!$user_information->nomor_registration){
            $data = $this->validate($request, [
                'nomor_registration' => 'required|unique:user_informations',
                'nomor' => 'required'
            ]);
            $user_information->update($data);
            $user_information->refresh();
        }
        if(isset($request->kirim_email)){
            try {
                Notification::send($user_information->user, new AgendaCreate($user_information));
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Email tidak terkirim');
            }
        }else{
            ApplicantReference::where('user_information_id', $id)->update([
                'status' => ApplicantReference::STATUS_APPROVE
            ]);
        }
        return redirect()->back()->with('success', 'Berhasil');
    }
    
    public function nomorsk_post(Request $request, $id)
    {
        $user_information = UserInformation::find($id);
        $data = $this->validate($request, [
            'nomor_krk' => 'required|unique:user_informations'
        ]);
        $user_information->update($data);
        return redirect()->back()->with('success', 'Berhasil buat Nomor SK');
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

    public function pemohon(Request $request)
    {
        $data = $this->validate($request, [
            'uuid' => 'required',
            'submitter' => 'required|string',
            'submitter_phone' => 'required|string',
            'nomor_ktp' => 'required|string',
            'address' => 'required|string',
            'activity_name' => 'required|string',
            'location_address' => 'required',
            'land_area' => 'required',
            'district_id' => 'required',
            'sub_district_id' => 'required',
            'land_status_id' => 'required',
            'nomor_hak' => 'required',
            'polygon' => 'sometimes|array',
        ]);
        $filter_data = Arr::except($data, ['polygon']);
        $user_information = UserInformation::whereUuid($data['uuid'])->first();
        if(isset($data['polygon'])){
            $filter_data['latitude'] = $data['polygon']['latitude'][0];
            $filter_data['longitude'] = $data['polygon']['longitude'][0];
        }
        $user_information->update($filter_data);
        if(isset($data['polygon'])){
            $filter_data['latitude'] = $data['polygon']['latitude'][0];
            $filter_data['longitude'] = $data['polygon']['longitude'][0];
            Polygon::where('user_information_id', $user_information->id)->delete();
            foreach ($data['polygon']['longitude'] as $key => $value) {
                Polygon::create([
                    'latitude' => $data['polygon']['latitude'][$key],
                    'longitude' => $value,
                    'user_information_id' => $user_information->id,
                ]);
            }
        }
        return redirect()->back()->with('success', 'Data berhasil di simpan');
    }

    public function agenda_approve(Request $request)
    {
        $data = $this->validate($request, [
            'uuid' => 'required',
            'to' => 'required',
            'note' => 'required',
        ],[
            'to' => 'Belum pilih proses selanjutnya',
            'note' => 'Catatan blm di isi',
        ]);
        $user_information = UserInformation::where('uuid', $data['uuid'])->first();
        if(!$user_information->nomor_registration){
            return redirect()->back()->with('error', 'Nomor Agenda blm di isi');
        }
        $data['user_information_id'] = $user_information->id;
        $data['from'] = Auth::guard('administrator')->user()->role;
        $data['from_id'] = Auth::guard('administrator')->user()->id;
        Riwayat::create($data);
        $data_information['agenda_date'] = date('Y-m-d H:i:s');
        $data_information['status'] = $data['to'];
        $user_information->update($data_information);
        return redirect()->route('agenda-berkas-proses')->with('success', 'Berhasil');
    }
    
    public function selesai_approve(Request $request)
    {
        $data = $this->validate($request, [
            'uuid' => 'required',
            'to' => 'required',
            'note' => 'required',
        ],[
            'to' => 'Belum pilih proses selanjutnya',
            'note' => 'Catatan blm di isi',
        ]);
        $user_information = UserInformation::where('uuid', $data['uuid'])->first();
        $data['user_information_id'] = $user_information->id;
        $data['from'] = Auth::guard('administrator')->user()->role;
        $data['from_id'] = Auth::guard('administrator')->user()->id;
        Riwayat::create($data);
        $data_information['agenda_date'] = date('Y-m-d H:i:s');
        $data_information['status'] = $data['to'];
        $user_information->update($data_information);
        return redirect()->route('agenda-selesai')->with('success', 'Berhasil');
    }
}
