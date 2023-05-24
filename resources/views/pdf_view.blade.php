<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            font-size: 11px;
            position: relative !important;
        }

        li {
            font-size: 11px !important;
        }

        td {
            padding: 2px;
        }

        tr {}
    </style>
</head>

<body>
    <header style="margin-top: -30px">
        <table style="width: 100%;">
            <tr>
                <td width="20%" align="center">
                    <img src="{{ asset('uploads/' . App\Models\Setting::whereGroup('LOGO')->first()->value) }}"
                        width="90px" height="120px" alt="" srcset="">
                </td>
                <td width="80%" align="center">
                    <p>
                        <span style='font-family: Tahoma, sans-serif;'>
                            <div style="line-height: 0.5;font-size: 22px;">PEMERINTAH KABUPATEN BOYOLALI </div> <br>
                            <strong>
                                <div style="line-height: 0.5;font-size: 22px;">DINAS PEKERJAAN UMUM DAN PENATAAN RUANG
                                </div> <br>
                            </strong>
                            <div style="line-height: 0.5;font-size: 14px;">Jalan Perintis Kemerdekaan No. 250 Boyolali
                                57316
                                Provinsi Jawa Tengah</div>
                            <br>
                            <div style="line-height: 0.5;font-size: 14px;">Telp\Fax : [0276] 321049, Email :
                                dpupr@boyolali.go.id, Website : www.dpupr.boyolali.go.id</div>
                        </span>
                    </p>
                </td>
            </tr>
        </table>

        <hr style="line-height: 0.1; text-align: center; border: 3px solid black;">
    </header>

    <p style="text-align: center;line-height: 0.5;"><strong style="line-height: 0.5;"><span
                style="font-size: 12px; line-height: 0.5;">KETERANGAN RENCANA KABUPATEN</span></strong></p>
    <table style="margin-left: auto; margin-right:auto;line-height: 0.5;">
        <tr>
            <td>NOMOR</td>
            <td>:</td>
            <td>{{ $user_information['nomor_krk'] }}</td>
        </tr>
        <tr>
            <td>TANGGAL </td>
            <td>:</td>
            <td>{{ (!$user_information['print_date'])?'':date('d-m-Y', strtotime($user_information['print_date'])) }}</td>
        </tr>
    </table>

    <p style="text-align: justify; line-height: 0.1;"><span style="font-size: 12px; line-height: 0.5;">DASAR HUKUM :
            &nbsp;</span></p>
    <ol style="margin-top: -15px">
        @foreach ($dasar_hukum as $item)
            @if (!empty($item))
                <li style="text-align: justify; font-size: 12px;">
                    {{ $item }}
                </li>
            @endif
        @endforeach
    </ol>
    <p style="text-align: justify;line-height: 0.1; "><span style="font-size: 12px; line-height: 0.5;">DATA PEMOHON :
            &nbsp;</span></p>
    <table border="1" style="width: 100%;margin-top: -15px">
        <tr>
            <td style="width:30%">NO. REGISTER</td>
            <td style="width:70%">{{ $user_information['nomor_registration'] }}</td>
        </tr>
        <tr>
            <td style="width:30%">PEMOHON</td>
            <td style="width:70%">{{ $user_information['submitter'] }}</td>
        </tr>
        <tr>
            <td style="width:30%">ALAMAT PEMOHON</td>
            <td style="width:70%">{{ $user_information['address'] }}</td>
        </tr>
        <tr>
            <td style="width:30%">LUAS LAHAN</td>
            <td style="width:70%">{{ $user_information['land_area'] }} M<sup>2</sup></td>
        </tr>
        <tr>
            <td style="width:30%">STATUS HAK / NO</td>
            <td style="width:70%">{{ $user_information['nomor_hak'] }}</td>
        </tr>
        <tr>
            <td style="width:30%">ALAMAT LOKASI</td>
            <td style="width:70%">{{ $user_information['location_address'] }}</td>
        </tr>
        <tr>
            <td style="width:30%">DESA / KELURAHAN</td>
            <td style="width:70%">{{ \App\Models\SubDistrict::find($user_information['sub_district_id'])->name }}</td>
        </tr>
        <tr>
            <td style="width:30%">KECAMATAN</td>
            <td style="width:70%">{{ \App\Models\District::find($user_information['district_id'])->name }}</td>
        </tr>
        <tr>
            <td style="width:30%">KOORDINAT (Polygon)</td>
            <td style="width:30%">({{ substr($user_information->latitude, 0, 10) }},
                {{ substr($user_information->longitude, 0, 10) }})
            </td>
        </tr>
        <tr>
            <td style="width:30%">KEGIATAN YANG DI MOHON</td>
            <td style="width:70%">{{ $user_information['activity_name'] }}</td>
        </tr>
    </table>
    <p style="line-height: 0.1;"><span style="font-size: 12px;">KETERANGAN RENCANA : &nbsp;</span></p>
    <div style="float-left;width: 100%;margin-top: -15px">
        <table style="width: 100%;" border="1">
            <tbody>
                <tr>
                    <td><strong> 1. Pola Ruang / Zona</strong> </td>
                    <td>{{ @\App\Models\Zona::find($user_information->krk->zona)->name }}</td>
                    <th colspan="6">
                        10. GSB (meter) Minimal
                    </th>
                </tr>
                <tr>
                    <td><strong> 2. Fungsi Bangunan yang di bangun</strong> </td>
                    <td>{{ @\App\Models\BuildingFunction::find($user_information->krk->building_function)->name }}
                    </td>
                    <td>JAP</td>
                    <td>{{ @!$user_information->gsb->jap ? '-' : @$user_information->gsb->jap }}</td>
                    <td colspan="4">Sungai Bertanggul</td>
                </tr>
                <tr>
                    <td> <strong> 3. KBG </strong> </td>
                    <td>{{ @!$user_information->krk->kbg ? '-' : 'Maks. ' . @$user_information->krk->kbg . ' Lantai' }}
                    </td>
                    <td>JKP</td>
                    <td>{{ @!$user_information->gsb->jkp ? '-' : @$user_information->gsb->jkp }}</td>
                    <td colspan="4">
                        {{ @!$user_information->krk->sungai_bertanggul ? '-' : @$user_information->krk->sungai_bertanggul }}
                    </td>
                </tr>
                <tr>
                    <td><strong> 4. KDB </strong> </td>
                    <td>{{ @!$user_information->krk->klb ? '-' : 'Maks. ' . @$user_information->krk->klb . ' %' }}
                    </td>
                    <td>JKS</td>
                    <td>{{ @!$user_information->gsb->jks ? '-' : @$user_information->gsb->jks }}</td>
                    <td colspan="4">Sungai tidak Bertanggul</td>
                </tr>
                <tr>
                    <td> <strong>5. KLB</strong> </td>
                    <td>{{ @!$user_information->krk->klb ? '-' : 'Maks. ' . @$user_information->krk->klb }}</td>
                    <td>JLP</td>
                    <td>{{ @!$user_information->gsb->jlp ? '-' : @$user_information->gsb->jlp }}</td>
                    <td colspan="4">
                        {{ @!$user_information->krk->sungai_tidak_bertanggul ? '-' : @$user_information->krk->sungai_tidak_bertanggul }}
                    </td>
                </tr>
                <tr>
                    @if ($user_information->activity_name == 'Perumahan')
                        <td> <strong> 6. PSU </strong></td>
                        <td>{{ @!$user_information->krk->psu ? '-' : 'Min ' . @$user_information->krk->psu }}</td>
                    @else
                        <td> <strong>6. KDH</strong></td>
                        <td>{{ @!$user_information->krk->kdh ? '-' : @$user_information->krk->kdh . ' %' }}</td>
                    @endif
                    <td>JLing</td>
                    <td>{{ @!$user_information->gsb->jling ? '-' : @$user_information->gsb->jling }}</td>
                    <td colspan="2">Waduk (titik pasang tertinggi)</td>
                    <td colspan="2">{{ @!$user_information->krk->waduk ? '-' : @$user_information->krk->waduk }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>JLS</td>
                    <td>{{ @!$user_information->gsb->jls ? '-' : @$user_information->gsb->jls }}</td>
                    <td colspan="2">Mata Air</td>
                    <td colspan="2">
                        {{ @!$user_information->krk->mata_air ? '-' : @$user_information->krk->mata_air }}
                    </td>
                </tr>
                <tr>
                    @if ($user_information->activity_name == 'Perumahan')
                    <td colspan="4"></td>
                    @else
                    <td colspan="2"></td>
                    <td> <strong> 8. KTB </strong> </td>
                    <td>{{ @!$user_information->krk->ktb ? '-' : @$user_information->krk->ktb }}
                    @endif
                    </td>
                    <td colspan="2">Tol (dari pagar)</td>
                    <td colspan="2">{{ @!$user_information->krk->tol ? '-' : @$user_information->krk->tol }}</td>
                </tr>
                <tr>
                    <td colspan="8"> <strong>7. Jaringan Utilitas (bebas bangunan)</strong> </td>
                </tr>
                <tr>
                    <td colspan="8">
                        {{ @!$user_information->krk->jaringan_utilitas ? '-' : @$user_information->krk->jaringan_utilitas }}
                    </td>
                </tr>
                @if ($user_information->activity_name == 'Perumahan')
                <tr>
                    <td colspan="8"><strong>9. Prasarana Jalan</strong></td>
                </tr>
                <tr>
                    <td colspan="8">{{ @$user_information->krk->prasarana_jalan }}</td>
                </tr>
                <tr>
                    <td colspan="8"><strong>10. Informasi Lainnya</strong></td>
                </tr>
                @else
                <tr>
                    <td colspan="8"><strong>9. Informasi Lainnya</strong></td>
                </tr>
                @endif
                <tr>
                    <td>a. SRP </td>
                    <td colspan="7">{{ @$user_information->krk->srp }}</td>
                </tr>
                <tr>
                    <td>b. KKOP </td>
                    <td colspan="7">{{ @$user_information->krk->kkop }}</td>
                </tr>
                <tr>
                    <td>c. Tambahan </td>
                    <td colspan="7">{{ @$user_information->krk->tambahan }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <table style="float:right;">
        <td>
            <center>
                <h5>
                    KEPALA DINAS PEKERJAAN UMUM DAN PENATAAN RUANG <br> KABUPATEN BOYOLALI
                </h5>
                @if (@$user_information->approval)
                    <img src="data:image/png;base64, {!! $approval !!}">
                @endif
                <br>
                <p>
                    <b><u>AHMAD GOJALI, S.Sos, M.T</u><br></b>
                    <small>Pembina Utama Muda</small><br>
                    NIP. 19730415 199403 1 007
                </p>
            </center>
        </td>
    </table>
    <p style="page-break-before: always">

        <center>
            <h4>LAMPIRAN PETA <br> KETERANGAN RENCANA KABUPATEN</h4>
        </center>
    <table style="margin-left: auto; margin-right:auto; line-height:1;">
        <tr>
            <td style="font-size: 14px">NOMOR</td>
            <td style="font-size: 14px">:</td>
            <td style="font-size: 14px">{{ $user_information['nomor_krk'] }}</td>
        </tr>
        <tr>
            <td style="font-size: 14px">TANGGAL </td>
            <td style="font-size: 14px">:</td>
            <td style="font-size: 14px">{{ (!$user_information['print_date'])?'':date('d-m-Y', strtotime($user_information['print_date'])) }}</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <div style="border-style:double;border-width: 3px;">
        <table style="margin-left: auto; margin-right:auto;width: 100%; padding:10;" border="1">
            <tr>
                @php
                    $image = @\App\Models\SketchFile::where('user_information_id', $user_information['id'])->first()->file;
                @endphp
                <td style="width: 50%"> <img class="img-thumbnail" width="400px"
                        src="{{ asset('storage/' . $image) }}" alt="" srcset=""></td>
                <td style="width: 50%">
                    <table style="font-size: 11px;margin:auto;">
                        <tbody>
                            <tr>
                                <td>Id</td>
                                <td>X</td>
                                <td>Y</td>
                            </tr>
                            @foreach ($user_information->polygons as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->latitude }}</td>
                                    <td>{{ $item->longitude }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <div style="margin:15px">
            <img src="data:image/png;base64, {!! $qrcode !!}">
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <footer>
        <table style="float:right;">
            <td>
                <center>
                    <h5>
                        KEPALA DINAS PEKERJAAN UMUM DAN PENATAAN RUANG <br> KABUPATEN BOYOLALI
                    </h5>
                    @if (@$user_information->approval)
                        <img src="data:image/png;base64, {!! $approval !!}">
                    @endif
                    <br>
                    <p>
                        <b><u>AHMAD GOJALI, S.Sos, M.T</u><br></b>
                        <small>Pembina Utama Muda</small><br>
                        NIP. 19730415 199403 1 007
                    </p>
                </center>
            </td>
        </table>
    </footer>
</body>
{{-- <script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    var array_polygons = {!! $user_information->polygons->pluck('longitude', 'latitude') !!};
    const entries = Object.entries(array_polygons);
    var polymarker = L.polygon(entries).getBounds().getCenter();
    var link = "https://www.google.com/maps/?q=" + polymarker.lat + "," + polymarker.lng;
    const qrCode = new QRCodeStyling({
        width: 200,
        height: 200,
        type: "png",
        data: link,
        imageOptions: {
            crossOrigin: "anonymous",
            margin: -50
        },
        dotsOptions: {
            // type: "dots"
        },
    });
    qrCode.append(document.getElementById("canvas"));
</script> --}}

</html>
