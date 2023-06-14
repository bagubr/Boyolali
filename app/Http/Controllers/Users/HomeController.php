<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ApplicantReference;
use App\Models\Polygon;
use App\Models\Procuration;
use App\Models\ReferenceType;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('users/proses');
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
        if ($user_information->user_id != Auth::user()->id) {
            return redirect()->route('proses');
        }
        return view('users/detail', compact('user_information'));
    }

    public function detail_approval(Request $request)
    {
        $id = $request->id;
        $user_information = UserInformation::whereUuid($id)->first();
        // if ($user_information->user_id != Auth::user()->id) {
        //     return redirect()->route('proses');
        // }
        return view('users/approval', compact('user_information'));
    }

    public function user_information(Request $request)
    {
        try {
        
        $data = $request->validate([
            'submitter' => 'required',
            'submitter_optional' => 'sometimes',
            'address' => 'required',
            'location_address' => 'required',
            'land_area' => 'required',
            'activity_name' => 'required',
            'district_id' => 'required',
            'sub_district_id' => 'required',
            'land_status_id' => 'required',
            'nomor_ktp' => 'required',
            'submitter_phone' => 'required',
            'nomor_hak' => 'required',
            'polygon' => 'required',
        ]);
        if($request->measurement_type == 'INPUT'){
            $data['latitude'] = $data['polygon']['latitude'][0];
            $data['longitude'] = $data['polygon']['longitude'][0];
        }
        if ($data['submitter_optional']) {
            $data['submitter'] .= ' ( ' . $data['submitter_optional'] . ' )';
        }
        $data['user_id'] = Auth::user()->id;
        $data['kbli_activity_id'] = NULL;
        $data['nomor_registration'] = NULL;
        $data['nomor_krk'] = NULL;
        DB::beginTransaction();
        $user_information = UserInformation::create($data);
        foreach ($data['polygon']['longitude'] as $key => $value) {
            Polygon::create([
                'latitude' => $data['polygon']['latitude'][$key],
                'longitude' => $value,
                'user_information_id' => $user_information->id,
            ]);
        }
        foreach ($request->file() as $key => $image) {
            $data_file['file'] = $request->file($key)->store('files');
            $data_file['is_upload'] = true;
            $data_file['user_information_id'] = $user_information->id;
            $data_file['reference_type_id'] = $key;
            ApplicantReference::create($data_file);
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
        $data = $this->validate($request, [
            'user_information_id' => 'required',
            'reference_type_id' => 'required',
            'file' => 'required|file',
        ]);
        $user_information = UserInformation::find($data['user_information_id']);
        if($user_information->status != UserInformation::STATUS_FILING){
            return redirect()->back()->with('error', 'Maaf Upload gagal, Pengajuan anda sedang/sudah di proses');
        }
        try {
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
