<?php

namespace App\Http\Controllers\Cetak;

use App\Http\Controllers\Controller;
use App\Models\DasarHukum;
use App\Models\UserInformation;
use App\Notifications\GenerateFile;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function generate(Request $request)
    {
        $data['user_information'] = UserInformation::whereUuid($request->id)->first();
        if(isset($request->kirim_email)){
            Notification::send($data['user_information']->user, new GenerateFile($data['user_information']));
            return redirect()->back()->with('success', 'Berhasil kirim Email');
        }
        $data = $this->validate($request, [
            'dasar_hukum' => 'required|array',
        ]);
        $data['user_information'] = UserInformation::whereUuid($request->id)->first();
        $data['qrcode'] = base64_encode(QrCode::format('svg')->size(70)->errorCorrection('H')->generate('https://www.google.com/maps/search/'.substr($data['user_information']->latitude, 0, 10).','.substr($data['user_information']->longitude, 0,10)));
        $data['approval'] = base64_encode(QrCode::format('svg')->size(70)->errorCorrection('H')->generate(route('detail-approval', ['id' => $data['user_information']->uuid])));
        // return view('pdf_view', ['user_information' => $data['user_information'], 'dasar_hukum' => $data['dasar_hukum'], 'qrcode' => $data['qrcode'], 'approval' => $data['approval']]); // Lihat Hasil HTML
        if(!$data['user_information']->print_date){
            $data['user_information']->update(['print_date' => date('Y-m-d H:i:s')]);
        }
        $pdf = FacadePdf::loadView('pdf_view', $data);
        $pdf->setPaper(array(0,0,609.4488,935.433), 'potrait');
        // return $pdf->stream(); // Lihat Hasil Pdf
        $content = $pdf->download()->getOriginalContent();
        Storage::put('krks/'.$data['user_information']->uuid.'.pdf',$content);
        return redirect()->back()->with('success', 'File berhasil di generate');
    }

    public function view(Request $request)
    {
        $data['user_information'] = UserInformation::whereUuid($request->id)->first();
        $data['dasar_hukum'] = DasarHukum::get()->pluck('content');
        $data['user_information'] = UserInformation::whereUuid($request->id)->first();
        $data['qrcode'] = base64_encode(QrCode::format('svg')->size(70)->errorCorrection('H')->generate('https://www.google.com/maps/search/'.substr($data['user_information']->latitude, 0, 10).','.substr($data['user_information']->longitude, 0,10)));
            $data['approval'] = base64_encode(QrCode::format('svg')->size(70)->errorCorrection('H')->generate(route('detail-approval', ['id' => $data['user_information']->uuid])));
        $pdf = FacadePdf::loadView('pdf_view', $data);
        $pdf->setPaper(array(0,0,609.4488,935.433), 'potrait');
        return $pdf->stream(); // Lihat Hasil Pdf
    }
}
