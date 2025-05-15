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
        .discussion-details {
        font-size: 20px;

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
            margin-bottom: 20px;
            text-align: justify;
            line-height: 1.2;

        }

        li {
            margin-top: 4px;
            text-align: justify;
            line-height: 1.2;
            font-size: 20px;

        }



        .courier {
            font-family: 'Courier New', Courier, monospace;
        }

	body {
    	font-family: 'Cambria', serif;
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
        <br>
        <p style="text-align:center; font-size: 30px; font-family:'Cambria', serif, monospace"><b><u>CLIENT CARE LETTER</u></b></p>
        <br><br>
        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
        <span style="font-family: 'Cambria', serif, monospace;">{{$data['newccl']->full_name_with_title ?? $data['enquiry']->full_name_with_title}}</span>
        </p>

        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">{!!$data['full_address']!!}</span>
            <span style="font-family: 'Cambria', serif, monospace;"><br /></span>
        </p>

        <p style="font-size: 20px;">By email to: <strong>{{$data['enquiry']->email}}</strong></p><br>

        <p style="font-size: 20px;">Your reference number: <strong>ENQ{{$data['enquiry']->id}}</strong></p><br>

        <p style="margin-bottom: 0.14in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">{{ \Carbon\Carbon::parse($data['date'])->format('d F Y') }}</span><br />
            <br />
        </p>

        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">Dear {{$data['newccl']->full_name_with_title ?? $data['enquiry']->full_name_with_title}},</span>
        </p><br>

        <p style="font-size: 20px;"><b><ul>Re: Your Immigration application(s)</ul></b></p><br>

        <div class="discussion-details">
            {!! $data['discussion_details'] !!}
        </div>
        <br>

    </div>
    <div>
    <h4 style= "page-break-before: always;" class="font-bold text-lg underline">Useful Links:</h4>
        <ol class="list-decimal pl-6 mt-2">
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">UKV&I approved Secure English Language Test (SELT)</a>
            </li>
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">UK Visa application fee</a>
            </li>
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">UK-Pre departure TB clearance certificate from an approved clinic</a>
            </li>
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">Immigration Health Surcharge (IHS) Fee</a>
            </li>
        </ol>
    </div>


    <br><br>

</body>

</html>
