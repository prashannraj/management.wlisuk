<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="generator" content="LibreOffice 6.4.6.2 (Linux)" />
    <meta name="author" content="WLIS" />
    <meta name="created" content="2020-09-19T10:54:00" />
    <meta name="changed" content="2020-10-19T17:20:19.522863811" />
    <meta name="AppVersion" content="16.0000" />
    <meta name="Company" content="BCL" />
    <meta name="DocSecurity" content="0" />
    <meta name="HyperlinksChanged" content="false" />
    <meta name="LinksUpToDate" content="false" />
    <meta name="ScaleCrop" content="false" />
    <meta name="ShareDoc" content="false" />
    <style>
        @php
        include(public_path('assets/css/argon.css'));
        @endphp
        @php include(public_path('assets/css/colors.css')) @endphp
        @php $export=true; @endphp
    </style>

    <style>
        body {
            background: "white";
            font-family: "Open Sans";
            line-height: 1;
        }

        p {
            font-size: 18px;
            color: black;
            line-height: 1;
        }

        .classic-table {
            width: 100%;
            color: #000;
        }

        th,
        tr {
            color: black;
        }
    </style>
</head>

<body lang="en-GB" link="#000080" vlink="#800000" dir="ltr">
@include('partials.page_number')

    <table class='classic-table' style="margin-bottom:20px">
        <tbody>
            <tr>
                <td colspan="3">
                    <table>
                        <tbody>
                            <tr>

                                <td>
                                    @if(isset($export) && $export)
                                    <img src="{{public_path($data['company_info']->logourl)}}" alt="">

                                    @else
                                    <img src="{{url($data['company_info']->logourl)}}" alt="">

                                    @endif
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="100%">
                </td>
                <td width="350px">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2"><b>{{$data['company_info']->name}}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">{{$data['company_info']->address}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">T: {{$data['company_info']->telephone}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">E: {{$data['company_info']->email}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">W: {{$data['company_info']->website}}</td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>

    <p align="center" style="text-transform:uppercase;color:#4f81bd;text-align:center;border-bottom: 1.00pt solid #4f81bd;font-weight:bold;font-size:20px">
        File Opening Form
    </p>
    <div style="text-align: right;">
    <span style="font-weight: bold;">REF:</span>
    <span style="font-weight: bold; padding: 5px 10px;">ENQ{{$data['enquiry']->id}}</span>
    </div>
    <p>{!! isset($data['content']) ? $data['content'] : '<b>Content is missing.</b>' !!}</p>
    <br>
    <br>
    <table style="width:100%">
        <tbody>
            <tr>
                <td style="width:100%">
                    <table>
                        <tbody>
                            <tr>
                                <td style="width:100%">
                                    <p>Signature: </p>
                                </td>
                                <td style="width: 100%;">
                                    <div style="border-bottom:1px solid color;width:290px;height: 1px;"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width:100%">
                    <table>
                        <tbody>
                            <tr>
                                <td style="width:100%">
                                    <p>Date: </p>
                                </td>
                                <td style='width: 100%;'>
                                    <p><b>{{ \Carbon\Carbon::parse(old('date', $data['clientofauthority']->date ?? ''))->format('d/m/Y') }}</b>
                                    </p>

                                    <div style="solid color;width:290px;height: 1px;"></div>


                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>



</body>

</html>
