<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ApplicantReference;
use App\Models\Procuration;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('users/home');
    }

    public function daftar()
    {
        return view('users/daftar');
    }

    public function proses()
    {
        return view('users/proses');
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $user_information = UserInformation::findOrFail($id);
        if($user_information->user_id != Auth::user()->id){
            return redirect()->route('proses');
        }
        return view('users/detail', compact('user_information'));
    }

    public function user_information(Request $request)
    {
        try {
            $data = $request->validate([
                'nomor_hak' => 'required', 
                'submitter' => 'required', 
                'address' => 'required',
                'location_address' => 'required',
                'land_area' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'activity_name' => 'required',
                'district_id' => 'required',
                'sub_district_id' => 'required',
                'land_status_id' => 'required',
                'nomor_ktp' => 'required',
                'submitter_phone' => 'required',
                'nomor_hak' => 'required',
                'name_procuration' => 'sometimes',
                'phone_procuration' => 'sometimes',
                'address_procuration' => 'sometimes',
            ]);
            $data['user_id'] = Auth::user()->id;
            $data['kbli_activity_id'] = NULL;
            $data['nomor_registration'] = NULL;
            $data['nomor_krk'] = NULL;
            DB::beginTransaction();
            $user_information = UserInformation::create($data);
            if($data['name_procuration']){
                $data_procuration = [];
                $data_procuration['name'] = $request->name_procuration;
                $data_procuration['phone'] = $request->phone_procuration;
                $data_procuration['address'] = $request->address_procuration;
                $data_procuration['user_information_id'] = $user_information->id;
                Procuration::create($data_procuration);
            }
            DB::commit();
            return redirect()->route('proses')->with('success', 'Pendaftaran Berhasil silahkan lanjutkan ke tahap selanjutnya');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Maaf Pendaftaran Gagal, Silahkan coba lagi nanti');
        }
    }

    public function upload(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'user_information_id' => 'required',
                'reference_type_id' => 'required',
                'file' => 'required|file',
            ]);
            DB::beginTransaction();
            $data['file'] = $request->file->store('files');
            $data['is_upload'] = true;
            ApplicantReference::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Berhasil Upload File !!!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', 'Maaf Upload gagal, Coba lagi nanti');
        }
    }
}
