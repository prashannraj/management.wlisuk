<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{{$data['filename']}}</title>

    <style type="text/css">
        body {
            font-size: 17px;
        }

        @page {
            size: 8.27in 11.69in;
            margin-left: 1.25in;
            margin-right: 1.25in;
            margin-top: 0.98in;
            margin-bottom: 0.49in
        }

        p {
            margin-bottom: 0.1in;
            direction: ltr;
            line-height: 115%;
            text-align: justify;
            orphans: 2;
            widows: 2;
            background: transparent
        }

        li p {
            display: inline;
            vertical-align: bottom;
            direction: ltr;
            line-height: 125%;
            text-align: left;

        }

        li {
            margin-bottom: 0.1in;
        }

        body {
            font-family: 'Cambria', serif;
        }

        h1 {
            margin-top: 0.28in;
            margin-bottom: 0.14in;
            border-top: none;
            border-bottom: 3.00pt double #732117;
            border-left: none;
            border-right: none;
            padding-top: 0in;
            padding-bottom: 0.01in;
            padding-left: 0in;
            padding-right: 0in;
            direction: ltr;
            text-transform: uppercase;
            color: #4d160f;
            font-size: 14pt;
            letter-spacing: 1.0pt;
            line-height: 120%;
            text-align: center;
            orphans: 2;
            widows: 2;
            background: transparent
        }

        a:link {
            color: #0000ff;
            text-decoration: underline
        }

        a:visited {
            color: #96a9a9;
            text-decoration: underline
        }
    </style>
</head>

<body lang="en-GB" link="#0000ff" vlink="#96a9a9" dir="ltr">
    @include('partials.page_number')
    <header style='border-bottom:2px solid red'>
        <table class='classic-table'>
            <tbody>
                <tr>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="{{public_path($data['company_info']->logourl)}}" alt="">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="100%">
                    </td>
                    <td width="300px">
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
    </header>
    <div class="">
        <br><br><br>

        <p style="text-align:center;
                font-weight: bold;
                margin-top: 0.35in; margin-bottom: 0.21in;
                /* border-top: 1px dotted #4d160f; border-bottom: 1px dotted #4d160f;  */
                border-left: none; border-right: none; padding-top: 0.01in; padding-bottom: 0.08in;
                padding-left: 0in; padding-right: 0in; text-transform: uppercase;
                letter-spacing: 2.5pt; line-height: 120%">
        <span color="#4d160f">
            <span size="6" style="font-size: 22pt">
                <span style="font-family:''Cambria', serif, monospace">
                    <span size="2" style="font-size: 11pt">CLIENT CARE LETTER</span>
                </span>
            </span>
        </span>
        </p>
        <p>
        <span style="font-family:''Cambria', serif, monospace">{{$data['newccl']->full_name_with_title}}</span>
        </p>
        <p>
        <span style="font-family:''Cambria', serif, monospace">{!!$data['full_address']!!}</span>
        <span style="font-family:''Cambria', serif, monospace"><br /></span>

        </p>

        <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:''Cambria', serif, monospace">{{ \Carbon\Carbon::parse($data['date'])->format('d F Y') }}</span><br />
        <br />
        </p>
        <p style="margin-bottom: 0in; line-height: 120%">
        <p class="No_20_Spacing"><span>Dear {{ $data['newccl']->full_name_with_title ?? $data['enquiry']->full_name_with_title }},</span> </p>
        <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
            <span style="font-family:''Cambria', serif, monospace">Thank
                you for your instructions. We are delighted to have the opportunity
                to act for you and trust we can bring your instructions to a
                satisfactory conclusion. </span>
        </p>
        <p style="text-align: justify;">{!! $data['discussion_details'] !!}</p>


</body>

</html>
