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



    <br>
    <br>
    <p style="text-decoration:underline;font-weight:bold;text-align:center">Enquiry/Initial Attendance Form</p>

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
                    {{$data['row']->full_address}}
                </td>
            </tr>

            <tr>
                <td>
                    Enquirer's Nationality:
                </td>
                <td>
                    {{$data['row']->nationality_country}}
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
            <tr><td>Refusal letter date (DD/MM/YYYY):</td><td>{{$data['row']->refusalLetterDate}}</td></tr>
            <tr><td>Refusal received date (DD/MM/YYYY):</td><td>{{$data['row']->refusalReceived}}</td></tr>
            <tr><td>Did you apply in the UK or outside the UK?</td><td>{{$data['row']->applicationLocation}}</td></tr>
            <tr><td>Visa application (UAN/GWF Number)</td><td>{{$data['row']->uan}}</td></tr>
            <tr><td>Post Reference/Ho Ref:</td><td>{{$data['row']->ho_ref}}</td></tr>
            <tr><td>How was the decision received?</td><td>{{$data['row']->method_decision_received}}</td></tr>
            <tr><td>Do you have a UK Sponsor?</td><td>{{$data['row']->has_uk_sponsor}}</td></tr>
            <tr><td>Sponsor Name:</td><td>{{($data['row']->sponsor_name)??''}}</td></tr>
            <tr><td>Relationship with Sponsor:</td><td>{{($data['row']->sponsor_relationship)??''}}</td></tr>
            <tr><td>Sponsor's Contact Email (if any):</td><td>{{($data['row']->sponsor_email)??''}}</td></tr>
            <tr><td>UK Sponsor Mobile/Contact:</td><td>{{($data['row']->sponsor_phone)??''}}</td></tr>
            <tr><td>Sponsor's Address:</td><td>{{($data['row']->sponsor_address)??''}}</td></tr>
            <tr><td>Sponsor City:</td><td>{{($data['row']->sponsor_city)??''}}</td></tr>
            <tr><td>UK preferred contact person, if different to the sponsor:</td><td>{{($data['row']->sponsor_preferred)??''}}</td></tr>
            <tr><td>UK preferred contact person's Email:</td><td>{{($data['row']->sponsor_preEmail)??''}}</td></tr>
            <tr><td>Application prepared by (Name/contact):</td><td>{{($data['row']->preparedby)??''}}</td></tr>
            <tr><td>Visa Application type:</td><td>{{($data['row']->visa)??''}}</td></tr>
            <tr><td>Their Contact details (Email/Telephone)::</td><td>{{($data['row']->appellant_email)??''}}</td></tr>
            <tr><td>Would you like to authorise additional contact who you wish to authorise to discuss your appeal matter?</td><td>{{($data['row']->authorise)??''}}</td></tr>
            <tr><td>Their Contact details (Email/Telephone)::</td><td>{{($data['row']->authorise_name)??''}}</td></tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p style="text-decoration:underline;font-weight:bold;text-align:left">Enquiry/Instruction/Discussion</p>
    <br>
    <div style="border:0.8px solid black;padding:20px">
        {{$data['row']->additional_details}}
    </div>
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
