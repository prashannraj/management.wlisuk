<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

    <title>Receipt No {{$data['receipt']->receipt_no}}</title>

    <style>
        @php include(public_path('assets/css/argon.css')) @endphp @php include(public_path('assets/css/colors.css')) @endphp @php $export=true;

        @endphp
    </style>


    <style>
    body {
            font-family: "Open Sans";
            font-size: 18px;
            line-height: 1;
        }
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

        .receipt-details td{
            padding-left:10px;
        }
    </style>
</head>

<body class='bg-white'>



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

    <h2 style="text-decoration:underline;text-align:center;color:black;margin-top:10px">
        RECEIPT {{$data['receipt']->receipt_no}}
    </h2>

    <table class='classic-table'  style="margin-top: 20px;margin-bottom: 20px;">
        <tbody>

            <tr>
                <td colspan="5" style="margin-top:10px;margin-bottom:10px">
                    <table>
                        <tbody>
                            <tr>
                                <td> {{$data['receipt']->client_name}}</td>
                            </tr>
                            <tr>
                                <td>{{$data['receipt']->address}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="100%"></td>
                <td width="300px">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                     <b>Receipt No:</b>
                                </td>
                                <td>
                                     {{$data['receipt']->receipt_no}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Invoice No:</b></td>
                                <td>
                                    {{$data['receipt']->invoice->invoice_no}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Date:</b></td>
                                <td>{{$data['receipt']->date}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <p style="color:black">
    <b>
    <u>
    Receipt Particulars
    </u>
    </b>
    </p>
    <table class='table-bordered receipt-details' width="100%">

        <tbody>
            <tr>
                <td> Amount Received</td>
                <td> {{$data['receipt']->currency->title}} {{$data['receipt']->amount_received}} </td>
            </tr>
            <tr>
                <td> Remarks</td>
                <td> {{$data['receipt']->remarks}}</td>
            </tr>

        </tbody>

    </table>

    <br><br>
    <table style="border:1px">
        <tbody>
            <tr>
                <td width="100%">
                    {{$data['company_info']->name}}. Registered in {{$data['company_info']->registered_in}}, Company Registration No. <b>{{$data['company_info']->registration_no}}</b>
                    , VAT Registration No. <b>{{$data['company_info']->vat}}</b>,  Regulated by {{$data['company_info']->regulated_by}}, Authorisation No. <b>{{$data['company_info']->regulation_no}}</b>.
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>