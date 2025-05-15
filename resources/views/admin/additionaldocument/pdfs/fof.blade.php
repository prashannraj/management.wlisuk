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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <style>
        @php include(public_path('assets/css/argon.css')) @endphp @php include(public_path('assets/css/colors.css')) @endphp @php $export=true;

        @endphp
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
        File opening form
    </p>


    <p align="justify" style="font-weight:bold;text-decoration:underline">
        Client Details:
    </p>
    <table width="601" style="width:1000px" cellpadding="7" cellspacing="0">


        <tbody>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Full Name:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['client_name']}}</b>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        D.O.B:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['client']->dob}}</b>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        National of:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['client']->nationality}}</b>

                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Applicant Current Address
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['address']}}</b>

                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Mobile
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['mobile']}}</b>

                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Email
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['email']}}</b>

                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top:10px"> I agree to this matter being opened.</p>
    <p align="" class='' style="margin-bottom: 0.14in">
        I agree my case/file information can be discussed or shared with the following individual:

    </p>
    <table style="width:1000px" cellpadding="7" cellspacing="0">


        <tbody>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Authorised person's name:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['authorised_person_name']}}</b>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Relationship to client:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['authorised_person_relationship']}}</b>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Address:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['authorised_person_address']}}</b>

                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Tel/Mobile:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['authorised_person_contact']}}</b>

                    </p>
                </td>
            </tr>

            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Email
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['authorised_person_email']}}</b>

                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Authorisation word
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['authorisation_word']}}</b>

                    </p>
                </td>
            </tr>
        </tbody>
    </table>




    <table class='' style="width:100%;margin-top: 20px;">
        <tbody>
            <tr>
                <td style="width: 100%;">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <p>Name: </p>
                                </td>
                                <td style="width: 100%;">
                                    <p style='padding-left:5px;font-weight:bold'> <span> </span>{{$data['client_name']}}
                                    </p>
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
                                    <p>Signature: </p>
                                </td>
                                <td style="width: 100%;">
                                    <div style="border-bottom:1px solid color;width:145px;height: 1px;"></div>
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
                                <td style="width: 100%;">
                                    @if($data["date"])
                                    <p><b>{{$data['date']}}</b>
                                    </p>
                                    @else
                                    <div style="border-bottom:1px solid color;width:145px;height: 1px;"></div>
                                    @endif
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