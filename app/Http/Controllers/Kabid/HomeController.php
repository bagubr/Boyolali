<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function proses_berkas()
    {
        return view('kabid/kabid');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('admin_templates/detail', compact('user_information'));
    }
}
