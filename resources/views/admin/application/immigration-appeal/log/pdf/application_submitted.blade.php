<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=OPen+Sans">


    <style>
        body {
            font-family: "Open Sans";
            font-size: 16px;
            line-height: 1;
        }

        p {
            margin-top: 4px;
            margin-bottom: 4px;
            text-align: justify;
            line-height: 1;

        }
    </style>


    <style>
        .classic-table {
            width: 100%;
            color: #000;

        }

        th,
        tr {
            color: #000;
        }

        .table-bordered td {
            border-color: #000;
        }

        .table-bordered th {
            border-color: #000;
        }

        .particular td {
            padding: 6px
        }
    </style>
</head>

<body>


    <header style='border-bottom:2px solid red'>
        <table class='classic-table'>
            <tbody>
                <tr>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>

                                    <td>
                                        <img src="{{public_path($data['companyinfo']->logourl)}}" alt="">


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
                                    <td colspan="2"><b>{{$data['companyinfo']->name}}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{$data['companyinfo']->address}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">T: {{$data['companyinfo']->telephone}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">E: {{$data['companyinfo']->email}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">W: {{$data['companyinfo']->website}}</td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
    </header>
   


    <p>{{$data['application_process']->application->student_name}}
        <br>
        {!!$data['application_process']->application->client->address_html!!}</p>

    <br>
    <p><b>{{date('d M Y')}}</b></p>
    <br>
    <p>Dear {{$data['application_process']->application->student_name}},</p>
    <br>


    <p style="text-decoration:underline;font-weight:bold;text-align:center">RE: Application Submission Confirmation</p>
    <br><br>
    <p>We are pleased to update you your application has been submitted as per your instruction.</p>
    <br>
    <table class='classic-table particular' border="1" style='border-collapse: collapse;'>
        <tbody>
        	<tr>
                <td>
                    Applicant's Name:
                </td>
                <td>
                    {{$data['application_process']->application->student_name}}
                </td>
            </tr>
            <tr>
                <td>
                    Country Applying:
                </td>
                <td>
                    {{$data['application_process']->application->country_name}}
                </td>
            </tr>
            <tr>
                <td>
                    Application Method:
                </td>
                <td>
                    {{ucfirst($data['application_process']->application->application_method)}}
                </td>
            </tr>



            <tr>
                <td>
                    Date Submitted:
                </td>
                <td>
                    {{$data['application_process']->application->date_submitted_format('d M Y')}}
                </td>
            </tr>


            <tr>
                <td>
                    Application Reference:
                </td>
                <td>
                    {{$data['application_process']->application->ref}}
                </td>
            </tr>



            <tr rowspan="2">
                <td>
                    Notes/other info:
                </td>
                <td>
                    {{$data['application_process']->application->note}}
                </td>
            </tr>

        </tbody>
    </table>
    <br>
    <p>
        We will update you with any progress as we hear from the authorities processing your application
        e.g. UKV&I, Home Office or other relevant authority.
    </p>
  
    <p>
        Please forward any direct correspondence you receive regarding the application to
        {{$data['companyinfo']->email}}. When contacting us please write your client ID and name
        (<b>{{$data['application_process']->application->client->id }}</b> - <b>{{$data['application_process']->application->student_name}}</b>)
        to ensure that the file is correctly updated.
    </p>

    <p>Please, disregard the above information if it is a repetition of the message sent previously.</p>
    <br>
    <p>Yours sincerely,</p>
    @if($data['application_process']->application->advisor)
    <br>
    <table class=''>
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img style="height:auto" src="{{public_path($data['application_process']->application->advisor->signature_url)}}" width="120" alt="">
                                </td>

                            </tr>
                            <tr>

                                <td>{{$data['application_process']->application->advisor->name}}</td>

                            </tr>
                            <tr>
                                <td>{{$data['companyinfo']->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <img style="height:auto" src="{{public_path($data['companyinfo']->stamp_url)}}" width="150" alt="">

                </td>
            </tr>
        </tbody>
    </table>
    @endif

<br><br>
<table style="border:1px">
        <tbody>
            <tr>
                <td width="100%">
                    {{$data['companyinfo']->name}}. Registered in {{$data['companyinfo']->registered_in}}, Company Registration No. <b>{{$data['companyinfo']->registration_no}}</b>
                    , Regulated by {{$data['companyinfo']->regulated_by}}, Authorisation No. <b>{{$data['companyinfo']->regulation_no}}</b>.
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>