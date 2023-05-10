<?php

namespace App\Http\Controllers\Cetak;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function generate(Request $request)
    {
        $data['user_information'] = UserInformation::whereUuid($request->id)->first();
        // return view('pdf_view', ['user_information' => $data['user_information']]);
        if(!$data['user_information']->print_date){
            $data['user_information']->update(['print_date' => date('d-m-Y H:i:s')]);
        }
        $pdf = FacadePdf::loadView('pdf_view', $data);
        return $pdf->stream('pdf_file.pdf');
    }
}
