<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employment Confirmation</title>
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
                                        <img src="{{public_path($data['company_info']->logourl)}}" alt="">


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
    </header>


    <br><br>
    {!!$data['content']!!}
    <br><br>
    <table style="border:1px">
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