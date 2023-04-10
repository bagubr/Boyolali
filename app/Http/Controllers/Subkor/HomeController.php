<?php

namespace App\Http\Controllers\Subkor;

use App\Http\Controllers\Controller;
use App\Models\Riwayat;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function proses_berkas()
    {
        return view('subkor/subkor');
    }

    public function cek()
    {
        return view('subkor/cek');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('admin_templates/detail', compact('user_information'));
    }

    public function approve(Request $request)
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
        $data_information['status'] = $data['to'];
        $user_information->update($data_information);
        return redirect()->route('subkor-berkas-proses')->with('success', 'Berhasil');
    }
}
