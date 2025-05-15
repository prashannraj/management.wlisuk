<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['filename']}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">


    <style>
        body {
            font-family: "Inconsolata";
            font-size: 18px;
            line-height: 1;
        }

        p {
            margin-top: 4px;
            margin-bottom: 4px;
            text-align: justify;
            line-height: 1.2;

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



    <p>

        {!!$data['coverletter']->to_address!!}
    </p>

	<br>
    <p><b>{{$data['coverletter']->date->format("d F Y")}}</b></p>
    <br>
    <p>Dear Sir/Madam,</p>
    <br>


    <p style="text-decoration:underline;font-weight:bold;text-align:center">RE: {{$data['coverletter']->re}}</p>
    <br>
    <div class="cover">
        {!! $data['coverletter']->text !!}
    </div>
    <br>
    <p>Together with the application the following documents are attached for
        your consideration:</p>
    @foreach($data['coverletter']->application_assessment->sections as $section)
    <p><u><b>{{$section->name}}</b></u></p>
    <table class='classic-table particular' border="1" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Document Description</th>
            </tr>
        </thead>
        <tbody>

            @foreach($section->documents as $i=>$doc)
            <tr>
                <td>
                    {{$i+1}}
                </td>
                <td>
                    {{$doc->description}}
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    @endforeach

    <br>
    <p>
        I look forward to receiving a positive outcome of the application at the
        earliest.
    </p>

   
    <br>
    <p>Yours sincerely,</p>
    @if($data['coverletter']->application->advisor)
    <br>
    <table class=''>
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img style="height:auto" src="{{public_path($data['coverletter']->application->advisor->signature_url)}}" width="120" alt="">
                                </td>

                            </tr>
                            <tr>

                                <td>{{$data['coverletter']->application->advisor->name}}</td>

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