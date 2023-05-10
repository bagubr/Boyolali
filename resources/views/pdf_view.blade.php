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
            font-size: 12px;
            position:relative !important;
        }

        ol {
            font-size: 12px;
        }

        td {
            padding: 2px;
        }
    </style>
</head>

<body>
    <table style="width: 100%;">
        <tr>
            <td width="20%" align="center">
                <img src="{{ url('Logo.png') }}" width="100px" height="120px" alt="" srcset="">
            </td>
            <td width="80%" align="center">
                <p>
                    <span style='font-family: Tahoma, sans-serif;'>
                        <div style="line-height: 0.5;font-size: 22px;">PEMERINTAH KABUPATEN BOYOLALI </div> <br>
                        <strong>
                            <div style="line-height: 0.5;font-size: 22px;">DINAS PEKERJAAN UMUM DAN PENATAAN RUANG
                            </div> <br>
                        </strong>
                        <div style="line-height: 0.5;font-size: 14px;">Jalan Perintis Kemerdekaan No. 250 Boyolali 57316
                            Provinsi Jawa Tengah</div>
                        <br>
                        <div style="line-height: 0.5;font-size: 14px;">Telp\Fax : [0276] 321049, Email :
                            dpupr@boyolali.go.id, Website : www.dpupr.boyolali.go.id</div>
                    </span>
                </p>
            </td>
        </tr>
    </table>

    <hr style="line-height: 0.5; text-align: center; border: 3px solid black;">
    <hr style="line-height: 0.5; text-align: center;">

    <p style="text-align: center;"><strong><span style="font-size: 16px; line-height: 0.5;">KETERANGAN RENCANA
                KABUPATEN&nbsp;</span></strong></p>
    <table style="margin-left: auto; margin-right:auto;">
        <tr>
            <td>NOMOR</td>
            <td>:</td>
            <td>{{ $user_information['nomor_registration'] }}</td>
        </tr>
        <tr>
            <td>TANGGAL </td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($user_information['print_date'])) }}</td>
        </tr>
    </table>

    <p style="text-align: justify; "><span style="font-size: 16px; line-height: 0.5;">DASAR HUKUM : &nbsp;</span></p>
    <ol>
        @foreach (\App\Models\DasarHukum::orderBy('id', 'desc')->get() as $item)
            <li style="text-align: justify; font-size: 16px;">
                {{ $item->content }}
            </li>
        @endforeach
    </ol>
    <p style="text-align: justify; "><span style="font-size: 16px; line-height: 0.5;">DATA PEMOHON : &nbsp;</span></p>
    <table border="1" style="width: 100%;">
        <tr>
            <td>NO. REGISTER</td>
            <td style="text-align: center;">:</td>
            <td>{{ $user_information['nomor_registration'] }}</td>
        </tr>
        <tr>
            <td>PEMOHON</td>
            <td style="text-align: center;">:</td>
            <td>{{ $user_information['submitter'] }}</td>
        </tr>
        <tr>
            <td>ALAMAT PEMOHON</td>
            <td style="text-align: center;">:</td>
            <td>{{ $user_information['address'] }}</td>
        </tr>
        <tr>
            <td>LUAS LAHAN</td>
            <td style="text-align: center;">:</td>
            <td>{{ $user_information['land_area'] }} M<sup>2</sup></td>
        </tr>
        <tr>
            <td>STATUS HAK / NO</td>
            <td style="text-align: center;">:</td>
            <td>{{ $user_information['nomor_hak'] }}</td>
        </tr>
        <tr>
            <td>ALAMAT LOKASI</td>
            <td style="text-align: center;">:</td>
            <td>{{ $user_information['location_address'] }}</td>
        </tr>
        <tr>
            <td>DESA / KELURAHAN</td>
            <td style="text-align: center;">:</td>
            <td>{{ \App\Models\SubDistrict::find($user_information['sub_district_id'])->name }}</td>
        </tr>
        <tr>
            <td>KECAMATAN</td>
            <td style="text-align: center;">:</td>
            <td>{{ \App\Models\District::find($user_information['district_id'])->name }}</td>
        </tr>
        <tr>
            <td>KOORDINAT (Polygon)</td>
            <td style="text-align: center;">:</td>
            <td>({{ substr($user_information->latitude, 0, 10) }}, {{ substr($user_information->longitude, 0, 10) }})
            </td>
        </tr>
        <tr>
            <td>KEGIATAN YANG DI MOHON</td>
            <td style="text-align: center;">:</td>
            <td>{{ $user_information['activity_name'] }}</td>
        </tr>
    </table>
    <p style="text-align: justify; "><span style="font-size: 16px; line-height: 0.5;">KETERANGAN RENCANA : &nbsp;</span>
    </p>
    <div style="margin-left:-5px;margin-right:-5px;">
        <div style="float: left;width: 50%;padding: 5px;">
            <table style="width: 100%;" border="1">
                <tbody>
                    <tr>
                        <td>1. Pola Ruang / Zona</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ \App\Models\Zona::find($user_information->krk->zona)->name }}</td>
                    </tr>
                    <tr>
                        <td>2. Fungsi Bangunan yang di bangun</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ \App\Models\BuildingFunction::find($user_information->krk->building_function)->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>3. KBG</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->kbg ? '-' : 'Maks. ' . $user_information->krk->kbg . ' Lantai' }}
                        </td>
                    </tr>
                    <tr>
                        <td>4. KDB</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->klb ? '-' : 'Maks. ' . $user_information->krk->klb . ' %' }}
                        </td>
                    </tr>
                    <tr>
                        <td>5. KLB</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->klb ? '-' : 'Maks. ' . $user_information->krk->klb }}</td>
                    </tr>
                    <tr>
                        <td>6. KDH</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->kdh ? '-' : $user_information->krk->kdh . ' %' }}</td>
                    </tr>
                    <tr>
                        <td>7. Jaringan Utilitas (bebas bangunan)</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->jaringan_utilitas ? '-' : $user_information->krk->jaringan_utilitas }}
                        </td>
                    </tr>
                    <tr>
                        <td>PSU</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->psu ? '-' : 'Min ' . $user_information->krk->psu }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="float: left;width: 40%;padding: 5px;">
            <div style="float: left;width: 100%;padding: 5px;">
                <table style="width: 100%;" border="1">
                    <tbody>
                        <tr>
                            <th colspan="3">
                                8. GSB (meter) Minimal
                            </th>
                        </tr>
                        <tr>
                            <td>JAP</td>
                            <td style="text-align: center;">:</td>
                            <td>{{ !$user_information->gsb->jap ? '-' : $user_information->gsb->jap . ' M' }}</td>
                        </tr>
                        <tr>
                            <td>JKP</td>
                            <td style="text-align: center;">:</td>
                            <td>{{ !$user_information->gsb->jkp ? '-' : $user_information->gsb->jkp . ' M' }}</td>
                        </tr>
                        <tr>
                            <td>JKS</td>
                            <td style="text-align: center;">:</td>
                            <td>{{ !$user_information->gsb->jks ? '-' : $user_information->gsb->jks . ' M' }}</td>
                        </tr>
                        <tr>
                            <td>JLP</td>
                            <td style="text-align: center;">:</td>
                            <td>{{ !$user_information->gsb->jlp ? '-' : $user_information->gsb->jlp . ' M' }}</td>
                        </tr>
                        <tr>
                            <td>JLS</td>
                            <td style="text-align: center;">:</td>
                            <td>{{ !$user_information->gsb->jls ? '-' : $user_information->gsb->jls . ' M' }}</td>
                        </tr>
                        <tr>
                            <td>JLing</td>
                            <td style="text-align: center;">:</td>
                            <td>{{ !$user_information->gsb->jling ? '-' : $user_information->gsb->jling . ' M' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="float: left;width: 30%;padding: 5px;">
            <table style="width: 100%;" border="1">
                <tbody>
                    <tr>
                        <td>Sungai Bertanggul</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->sungai_bertanggul ? '-' : $user_information->krk->sungai_bertanggul . ' M' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Sungai Bertanggul</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->sungai_tidak_bertanggul ? '-' : $user_information->krk->sungai_tidak_bertanggul . ' M' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Mata Air</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->mata_air ? '-' : $user_information->krk->mata_air . ' M' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Waduk (titik pasang tertinggi)</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->waduk ? '-' : $user_information->krk->waduk . ' M' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Tol (dari pagar)</td>
                        <td style="text-align: center;">:</td>
                        <td>{{ !$user_information->krk->tol ? '-' : $user_information->krk->tol . ' M' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
        <p style="page-break-before: always">
            <center>
                <h3>LAMPIRAN PETA <br> KETERANGAN RENCANA KABUPATEN</h3>
            </center>
        <table style="margin-left: auto; margin-right:auto;">
            <tr>
                <td>NOMOR</td>
                <td>:</td>
                <td>{{ $user_information['nomor_registration'] }}</td>
            </tr>
            <tr>
                <td>TANGGAL </td>
                <td>:</td>
                <td>{{ date('d-m-Y', strtotime($user_information['print_date'])) }}</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table style="margin-left: auto; margin-right:auto;width: 100%; padding:10;" border="1">
            <tr>
                @php
                    $image = \App\Models\SketchFile::where('user_information_id', $user_information['id'])->first()->file;
                @endphp
                <td style="width: 50%"> <img class="img-thumbnail" width="400px"
                        src="{{ asset('storage/' . $image) }}" alt="" srcset=""></td>
                <td style="width: 50%">
                    <table style="font-size: 12px;margin:auto;">
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
        <br>
        <br>
        <br>
        <br>
        <br>
        <table style="float:right;">
            <td>
                <center>
                    <h6>
                        KEPALA DINAS PEKERJAAN UMUM DAN PENATAAN RUANG <br> KABUPATEN BOYOLALI
                    </h6>
                    <br>
                    <br>
                    <br>
                    <p>
                        <b><u>AHMAD GOJALI, S.Sos, M.T</u><br></b>
                        <small>Pembina Utama Muda</small><br>
                        NIP. 19730415 199403 1 007
                    </p>
                </center>
            </td>
        </table>
</body>

</html>
