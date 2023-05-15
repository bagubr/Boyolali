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
        // $user_informations->whereStatus($request->status)
        $user_informations->where('user_id', Auth::user()->id);
        $totalRecords = $user_informations
        ->count();
        $user_informations = $user_informations
        ->orderBy('id')
        ->skip($start)
        ->take($rowperpage)
        ->get();
        $data_arr = array();
        $id = $start + 1;
        foreach ($user_informations as $value) {
            $data_arr[] = array(
                "id" => $id++,
                "created_at" => date('d-M-Y', strtotime($value->created_at)),
                "nomor_registration" => $value->nomor_registration,
                "submitter" => $value->submitter,
                "submitter_phone" => $value->submitter_phone,
                "location_address" => $value->location_address,
                "status" => $value->keterangan_status,
                "action" => $this->action($value->uuid)
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
        $user_information = UserInformation::where('uuid', $id)->first();
        $id = $user_information->id;
        if($user_information->nomor_krk){
            return "<a href='".route('detail', ['id' => $id])."' class='badge bg-primary' style='text-decoration: none;'>Detail</a><a href='#' class='badge bg-success' style='text-decoration: none;'>Download</a>";
        }
        return "<a href='".route('detail', ['id' => $id])."' class='badge bg-primary' style='text-decoration: none;'>Detail</a>";
    }
}
