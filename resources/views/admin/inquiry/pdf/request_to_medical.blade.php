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
        h1, h2, h3, h4, h5, h6 {
            color: black;
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


    <h3 align="center" style="color:#000000;text-align:center;font-weight:bold;font-size:20px">
        Request Acess to Medical Records
    </h3>
    <p align="center" style="text-transform:uppercase;color:#000000;text-align:center;border-bottom: 1.00pt solid #000000;font-weight:bold;font-size:15px">
     Private and Confidential
    </p>
    <div style="text-align: right;">
    <span style="font-weight: bold; padding: 5px 10px;">REF: ENQ{{$data['enquiry']->id}}</span>
    </div>

    <p align="left" style="color:#030303;text-align:left;font-weight:bold;font-size:17px; padding-left: 19px;">
       Date: {{ \Carbon\Carbon::parse(old('date', $data['requesttomedical']->date ?? ''))->format('d M Y') }}
    </p>
    <p style="color:#030303;text-align:left;margin:0; padding-left: 19px;">Medical Practice Name and Address:</p>
    <p align="left" style="color:#030303;text-align:left;font-weight:bold;font-size:17px;margin:0;padding-left: 19px;">
      {!! isset($data['practice_name']) ? $data['practice_name'] : '<b>Content is missing.</b>' !!}, {!! isset($data['practice_address']) ? $data['practice_address'] : '<b>Content is missing.</b>' !!}
    </p>
    <br>

    <p>{!! isset($data['content']) ? $data['content'] : '<b>Content is missing.</b>' !!}</p>

<br>



</body>

</html>
