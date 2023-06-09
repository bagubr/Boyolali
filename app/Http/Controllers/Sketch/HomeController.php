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
            'srp' => 'sometimes|nullable|string',
            'kkop' => 'sometimes|nullable|string',
            'tambahan' => 'sometimes|nullable|string',
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
