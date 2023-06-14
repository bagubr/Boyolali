<?php

namespace App\Http\Controllers;

use App\Models\SubDistrict;
use Illuminate\Http\Request;

class SubDistrictController extends Controller
{
    public function sub_district(Request $request)
    {
        $data['sub_districts'] = SubDistrict::select('id', 'name', 'district_id')
        ->where('district_id', $request->district_id)
        ->when($request->name, function ($query) use ($request)
        {
            $query->where('name', 'like', '%'.$request->name.'%');
        })
        ->get();
        $data = [
            'code' => 200,
            'message' => 'Successfully Get Data',
            'data' => $data,
        ];
        return response()->json($data, 200);
    }
}
