<?php

namespace App\Http\Controllers\Rekap;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('rekap/index');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('admin_templates/detail', compact('user_information'));
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = @$request->get("start")??0;
        $rowperpage = @$request->get("length")??10;
        $search_arr = $request->get('search');
        $searchValue = @$search_arr['value']; 
        $min_date = @$request->get('min_date'); 
        $max_date = @$request->get('max_date'); 
        $year = @$request->get('year'); 
        $month = @$request->get('month'); 
        
        $user_informations = UserInformation::query();
        $user_informations->whereStatus('SELESAI');
        $user_informations->when($searchValue != '', function ($query) use ($searchValue)
        {
            $query->where(function ($query) use ($searchValue) {
                $query->orWhere('nomor_registration', 'like', '%' . $searchValue . '%');
                $query->orWhere('submitter', 'like', '%' . $searchValue . '%');
                $query->orWhere('submitter_phone', 'like', '%' . $searchValue . '%');
                $query->orWhere('location_address', 'like', '%' . $searchValue . '%');
                $query->orWhere('nomor_krk', 'like', '%' . $searchValue . '%');
            });
        });

        $user_informations->when($year, function ($query) use ($year)
        {
            $query->whereYear('print_date', $year);
        });
        $user_informations->when($month, function ($query) use ($month)
        {
            $query->whereMonth('print_date', $month);
        });
        $user_informations->when($min_date && $max_date, function ($query) use ($min_date, $max_date)
        {
            $query->whereBetween('print_date', [date('Y-m-d H:i:s', strtotime($min_date)), date('Y-m-d H:i:s', strtotime($max_date))]);
        });
        // $user_informations->where('user_id', Auth::user()->id);
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
                "nomor_krk" => $value->nomor_krk,
                "print_date" => $value->print_date,
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
        if($user_information->nomor_krk){
            return "<a href='".route('berkas-selesai-detail', ['id' => $id])."' class='badge bg-primary text-white' style='text-decoration: none;'>Detail</a><a href='".asset('storage/krks/' . $user_information->uuid . '.pdf')."' class='badge bg-success text-white' style='text-decoration: none;' target='_blank'>Download</a>";
        }
        return "<a href='".route('berkas-selesai-detail', ['id' => $id])."' class='badge bg-primary text-white' style='text-decoration: none;'>Detail</a>";
    }
}
