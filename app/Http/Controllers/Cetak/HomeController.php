<?php

namespace App\Http\Controllers\Cetak;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use App\Notifications\GenerateFile;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function generate(Request $request)
    {
        $data = $this->validate($request, [
            'dasar_hukum' => 'required|array',
        ]);
        $data['user_information'] = UserInformation::whereUuid($request->id)->first();
        // return view('pdf_view', ['user_information' => $data['user_information']]);
        if(!$data['user_information']->print_date){
            $data['user_information']->update(['print_date' => date('d-m-Y H:i:s')]);
        }
        $pdf = FacadePdf::loadView('pdf_view', $data);
        $pdf->setPaper('A4');
        $content = $pdf->download()->getOriginalContent();
        Storage::put('krks/'.$data['user_information']->uuid.'.pdf',$content);
        try {
            Notification::send($data['user_information']->user, new GenerateFile($data['user_information']));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Berhasil generate file, Email tidak terkirim');
        }
        return redirect()->back()->with('success', 'File berhasil di generate');
    }
}
