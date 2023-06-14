<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function district(Request $request)
    {
        $data['districts'] = District::select('id', 'name')
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
