<?php

namespace App\Http\Controllers\Pencarian;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('pencarian/index');
    }

    public function detail(Request $request)
    {
        $user_information = UserInformation::whereUuid($request->id)->first();
        return view('admin_templates/detail', compact('user_information'));
    }

    public function pencarian_data(Request $request)
    {
        $draw = $request->get('draw');
        $start = @$request->get("start") ?? 0;
        $rowperpage = @$request->get("length") ?? 0;
        $search_arr = $request->get('search');

        $searchValue = @$search_arr['value'] ?? '';

        $user_informations = UserInformation::query();
        $user_informations->where(function ($query) use ($searchValue) {
            $query->whereNomorRegistration($searchValue);
            $query->orWhere('submitter', 'like', '%' . $searchValue . '%');
            $query->orWhere('submitter_phone', 'like', '%' . $searchValue . '%');
            $query->orWhere('location_address', 'like', '%' . $searchValue . '%');
            $query->where('user_id', Auth::guard('administrator')->user()->id);
        });
        $totalRecords = $user_informations
            ->count();
        $user_informations = $user_informations
            ->orderBy('id')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        $id = $start + 1;
        if ($searchValue) {
            foreach ($user_informations as $value) {
                $data_arr[] = array(
                    "id" => $id++,
                    "nomor_registration" => $value->nomor_registration,
                    "submitter" => $value->submitter,
                    "location_address" => $value->location_address,
                    "nomor_krk" => $value->nomor_krk,
                    "action" => $this->action($value->uuid)
                );
            }
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
        return "<a href='" . route('pencarian-detail', ['id' => $id]) . "' class='badge bg-primary text-white'>Detail</a>";
    }
}
