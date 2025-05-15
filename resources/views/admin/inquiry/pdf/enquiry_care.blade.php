<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{{$data['filename']}}</title>

    <style type="text/css">
        .classic-table {
            width: 100%;
            color: #000;

        }
         @page {
            size: 9in 11.69in;
            margin-left: 1.0in;
            margin-right: 1.00in;
            margin-top: 0.49in;
            margin-bottom: 0.49in
        }

        p {
            margin-top: 4px;
            margin-bottom: 4px;
            text-align: justify;
            line-height: 1.2;

        }



        .courier {
            font-family: 'Courier New', Courier, monospace;
        }

	body {
    	font-family: Courier !important;
    	/*font-size: initial !important;*/
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
                    <td width="450px">
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
        <p style="margin-bottom: 0in; line-height: 120%">
            <span style="font-family:'Courier New', Courier, monospace">{{$data['enquiry']->full_name_with_title}}</span>
        </p>
        <p style="margin-bottom: 0in; line-height: 120%">
            <span style="font-family:'Courier New', Courier, monospace">{!!$data['full_address']!!}</span>
            <span style="font-family:'Courier New', Courier, monospace"><br />
            </span>

        </p>

        <p style="margin-bottom: 0.14in; line-height: 120%">
            <span style="font-family:'Courier New', Courier, monospace">{{$data['date']}}</span><br />
            <br />
        </p>
        <p style="margin-bottom: 0in; line-height: 120%">
            <span style="font-family:'Courier New', Courier, monospace">Dear {{$data['enquiry']->title}}. {{$data['enquiry']->surname}},</span>
        </p>

        	{!! $data['coverletter_content'] !!}

        <br>
        <p style="margin-bottom: 0.14in; line-height: 120%">
            <span style="font-family:'Courier New', Courier, monospace">Kind
                regards,</span>
        </p>
        <br>
        <table class=''>
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <img style="height:auto" src="{{public_path($data['advisor']->signature_url)}}" width="120" alt="">
                                    </td>

                                </tr>
                                <tr>

                                    <td>{{$data['advisor']->name}}</td>

                                </tr>
                                <tr>
                                    <td>{{$data['company_info']->name}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <img style="height:auto" src="{{public_path($data['company_info']->stamp_url)}}" width="150" alt="">

                    </td>
                </tr>
            </tbody>
        </table>


    </div>
    <br><br>
    <table style="border:1px" class="">
        <tbody>
            <tr>
                <td width="100%">
                    {{$data['company_info']->name}}. Registered in {{$data['company_info']->registered_in}}, Company Registration No. <b>{{$data['company_info']->registration_no}}</b>
                    , Regulated by {{$data['company_info']->regulated_by}}, Authorisation No. <b>{{$data['company_info']->regulation_no}}</b>.
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
