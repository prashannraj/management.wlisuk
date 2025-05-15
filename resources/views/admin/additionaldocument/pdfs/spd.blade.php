<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="generator" content="LibreOffice 6.4.6.2 (Linux)" />
    <meta name="author" content="Rupak Paudyal" />
    <meta name="created" content="2020-10-22T14:39:00" />
    <meta name="changed" content="2020-11-05T16:14:16.402325692" />
    <meta name="AppVersion" content="16.0000" />
    <meta name="DocSecurity" content="0" />
    <meta name="HyperlinksChanged" content="false" />
    <meta name="LinksUpToDate" content="false" />
    <meta name="ScaleCrop" content="false" />
    <meta name="ShareDoc" content="false" />
    <title> Sponsor document </title>
    <style>
  
    </style>

    <style>
        body {
            background: "white";
            font-family: "Open Sans";
            line-height: 1;
        }

        p {
            font-size: 17px;
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

        h2 {
            color: #000;
            text-align: center;
            text-decoration: underline;
        }
        .box{
            border:0.5px solid black;
            width:100%;
            height:400px;
            margin: 20px 0px;
        }
    </style>
</head>

<body lang="en-US" link="#000080" vlink="#800000" dir="ltr">
@include('partials.page_number')

    <h2>
        Sponsor Declaration</h2>
    <p><br></p>
    <p style="margin-bottom: 0in; line-height: 100%">
        I, <b>{{$data['authorised_person_name']}}</b>, d.o.b. {{\Carbon\Carbon::createFromFormat(config('constant.date_format'),$data['authorised_person_dob'])->format("d F Y")}} of {{$data['authorised_person_address']}} <span style="font-size:medium;font-weight: bold;">DO SOLEMNLY AND SINCERELY DECLARE</span> as
        follows:
    </p>
    <div style="margin:20px 0px">
    {!! $data['declaration'] !!}
    </div>

    <p style="line-height: 108%">
        Signed
        ……………………………………………………
        <br>
        {{$data['authorised_person_name']}}
        <br>
        Mobile/Tel: <b>{{$data['authorised_person_contact']}}</b>
        <br />
        Email: <b>{{$data['authorised_person_email']}}</b><br>
        Date: <b>{{$data['date']}}</b>
    </p>

</body>

</html>