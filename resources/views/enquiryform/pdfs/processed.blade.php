<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Verified</title>
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




    <div style="display: flex; justify-content: space-between;">
        <p style="text-decoration:underline;font-weight:bold;text-align:center">Enquiry/Initial Attendance Form</p>
        <h2 style="text-align:right; color:rgb(76, 76, 76)">{{ $data['processed'] ? "ENQ{$data['enquiry']->id}" : 'Not Processed' }}</h2>
      </div>

    <br>
    <table class='classic-table particular' border="1" style='border-collapse: collapse;'>
        <tbody>
            <tr>
                <td>
                    Form Type:
                </td>
                <td>
                    {{$data['row']->form->name}}
                </td>
            </tr>
            <tr>
                <td>
                    Full Name:
                </td>
                <td>
                    {{$data['row']->title.". ".$data['row']->full_name}}
                </td>
            </tr>
            <tr>
                <td>
                    Email:
                </td>
                <td>
                    {{$data['row']->email}}
                </td>
            </tr>
            <tr>
                <td>
                    Tel/Mobile:
                </td>
                <td>
                    {{$data['row']->contact_number}}
                </td>
            </tr>

            <tr>
                <td>
                    Enquirer's Address:
                </td>
                <td>
                    {{$data['row']->appellant_address.", ". $data['row']->postal_code .", ". ucwords(strtolower($data['row']->nationality_country)) }}
                </td>
            </tr>

            <tr>
                <td>
                    Enquirer's Nationality:
                </td>
                <td>
                    @foreach($data['countries'] as $country)
                    @if($country->id == $data['row']->appellant_nation)
                            {{ ucwords(strtolower($country->title)) }}
                    @break
                    @endif
                    @endforeach
                </td>
            </tr>

            <tr>
                <td>
                    Email Verification:
                </td>
                <td>
                    {{$data['row']->validated_status}}
                </td>
            </tr>


        </tbody>
    </table>
    <br>
    <p style="text-decoration:underline;font-weight:bold;text-align:left">Enquiry/Instruction/Discussion</p>
    <br>
    <br>
    <div style="border:0.8px solid black;padding:20px">
         {{$data['row']->notes}}
    </div>
    <br>
    <br>

    <div class="form-group">
        <input class="form-check-input" type="checkbox" id="allow" name='allow' checked value="1" />
        <label for="allow">
        I consent {{$data['companyinfo']->name}} to contact me regarding my enquiry and add my details to their mailing list.
I consent {{$data['companyinfo']->name}} to record my Internet Protocol (IP) address upon submission of this enquiry form.
I consent {{$data['companyinfo']->name}} to hold my personal information and IP address on their web server in the UK or in the EEA in compliance with Data Protection Act 2018 (GDPR).
        </label>

    </div>
    <p>Consent message above ticked: <b>{{$data['row']->created_at_formatted}}</b></p>

    <p>Consentee's Name: <b>{{$data['row']->full_name}}</b></p>





</body>

</html>
