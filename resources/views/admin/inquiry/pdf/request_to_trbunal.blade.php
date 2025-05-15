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


    <h3 align="center" style="text-transform:uppercase;color:#4f81bd;text-align:center;font-weight:bold;font-size:20px">
        Request access to Tribunal determination
    </h3>
    <p align="center" style="text-transform:uppercase;color:#4f81bd;text-align:center;border-bottom: 1.00pt solid #4f81bd;font-weight:bold;font-size:15px">
     Private and Confidential
    </p>
    <div style="text-align: right;">
    <span style="font-weight: bold; padding: 5px 10px;">REF: ENQ{{$data['enquiry']->id}}</span>
    </div>
    <p align="left" style="color:#030303;text-align:left;font-size:18px">
      Date: <strong>{{ \Carbon\Carbon::parse(old('date', $data['requesttotrbunal']->date ?? ''))->format('d M Y') }}</strong><br>
    </p>
    <p align="left" style="color:#030303;text-align:left;font-size:18px">
        Tribunal reference number (if known): <strong>{!! isset($data['reference_number']) ? $data['reference_number'] : '<b>Content is missing.</b>' !!}</strong>
    </p>
    <p>{!! isset($data['content']) ? $data['content'] : '<b>Content is missing.</b>' !!}</p>

<br>



</body>

</html>
