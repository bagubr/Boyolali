<?php

namespace App\Http\Controllers;

use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = @$request->get("start")??0;
        $rowperpage = @$request->get("length")??0;
        $search_arr = $request->get('search');
        
        $searchValue = @$search_arr['value']??''; 
        
        $user_informations = UserInformation::query();
        $user_informations->whereStatus($request->status)
        ->where('user_id', Auth::user()->id);
        $totalRecords = $user_informations
        ->count();
        $user_informations = $user_informations
        ->orderBy('created_at', 'desc')
        ->skip($start)
        ->take($rowperpage)
        ->get();
        $data_arr = array();
        $id = $start + 1;
        foreach ($user_informations as $value) {
            $data_arr[] = array(
                "id" => $id++,
                "created_at" => date('d-M-Y', strtotime($value->created_at)),
                "submitter" => $value->submitter,
                "submitter_phone" => $value->submitter_phone,
                "location_address" => $value->location_address,
                "status" => $value->keterangan_status,
                "action" => $this->action($value->id)
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data_arr,
        );
        return $response;
        echo json_encode($response);
    }

    function action($id)
    {
        return "<a href='".route('detail', ['id' => $id])."' class='badge bg-primary' style='text-decoration: none;'>Detail</a>";
    }
}
